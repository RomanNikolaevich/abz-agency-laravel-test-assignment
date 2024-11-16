<template>
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">Users List</h1>
        <UserList :userCount="userCount"
                  :pageCount="pageCount"
                  @countChange="userCount = $event"
                  @pageChange="pageCount = $event"
        />
    </div>
</template>

<script>
import UserList from '../components/UsersList.vue';

export default {
    name: 'UsersListPage',
    components: {
        UserList,
    },
    data() {
        return {
            userCount: 6,
            pageCount: 1
        };
    }
};
</script>
