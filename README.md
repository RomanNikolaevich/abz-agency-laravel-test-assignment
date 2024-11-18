## About the Project

This project is a test assignment for the **Back-end Developer (PHP, Laravel)** position. It demonstrates the implementation of a REST API server with a minimal frontend to showcase the API's functionality.

### Features
- **REST API**: Built according to the [Technical Assignment](https://drive.google.com/file/d/1d5sXqu24Toe0AL2lzS1qg18lGQwmbsCb/view) and  [API Documentation](https://openapi_apidocs.abz.dev/frontend-test-assignment-v1/).
- **Token-based Authorization**: Secures access to protected endpoints.
- **Data Management**: Includes seeders to populate the database with realistic user data.
- **Image Processing**:
    - Crops user photos to 70x70px (center/center).
    - Optimizes images using the Tinify API.
- **Frontend**:
    - Displays a paginated user list (6 users per page).
    - Provides a form to add new users with server-side validation.

### Technologies Used
- **Backend**: PHP 8.2, Laravel 11.9, MySQL 8.0.
- **Frontend**: Vue 3.5.
- **Image Optimization**: Tinify API.

## Challenges

- Streamlining Tinify API integration for efficient image processing.
- Adhering strictly to OpenAPI specifications.
- Delivering a functional frontend while focusing primarily on backend tasks.

---

## Getting Started

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/RomanNikolaevich/abz-agency-laravel-test-assignment.git
2. Install dependencies:
    ```bash
    composer install
    npm install
3. Configure the .env file for your database and API keys
   ```bash
   php artisan key:generate
4. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
5. Start the development server:
    ```bash
   php artisan serve
   npm run dev


## Deployment
The project has been deployed for live testing.
[Deployed Application Link](http://3057536.backend5.web.hosting-test.net/)





 
