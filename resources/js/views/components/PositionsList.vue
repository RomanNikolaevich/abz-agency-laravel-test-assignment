<template>
    <div>
        <label for="positions" class="block text-sm font-medium text-gray-700">Select Position</label>
        <select
            id="positions"
            v-model="localPosition"
            @change="updatePosition"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
            <option value="" disabled>Select a position</option>
            <option v-for="position in positions" :key="position.id" :value="position.id">
                {{ position.name }}
            </option>
        </select>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        positionId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            positions: [],
            localPosition: this.positionId,
        };
    },
    methods: {
        updatePosition() {
            this.$emit('update:positionId', this.localPosition);
        },
    },
    mounted() {
        axios.get('/api/v1/positions')
            .then(response => {
                if (response.data.success) {
                    this.positions = response.data.positions;
                }
            })
            .catch(error => {
                console.error('Error fetching positions:', error);
            });
    },
};
</script>
