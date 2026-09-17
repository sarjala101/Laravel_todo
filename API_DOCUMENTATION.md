# Laravel Sanctum Profile & Sub-collections API Documentation

This documentation provides the reference for integrating the Flutter application with the updated Laravel Sanctum User Profile API.

## Base URL
```
http://<your-domain-or-ip>:8000/api
```

## Headers
For all protected endpoints, include the following HTTP headers:
```http
Authorization: Bearer <token>
Accept: application/json
Content-Type: application/json
```

---

## 1. Authentication Endpoints

> [!NOTE]
> Authentication endpoints remain unchanged.

### Register User
- **Endpoint**: `POST /register`
- **Authentication**: None required
- **Request Body**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secretpassword",
  "password_confirmation": "secretpassword"
}
```
- **Validation Rules**:
  - `name`: required | string | max:255
  - `email`: required | email | unique:users,email
  - `password`: required | string | min:6 | confirmed
- **Response (200 OK)**:
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2026-09-17T07:00:00.000000Z",
    "updated_at": "2026-09-17T07:00:00.000000Z"
  },
  "token": "1|sanctum_token_string_here"
}
```

### Login User
- **Endpoint**: `POST /login`
- **Authentication**: None required
- **Request Body**:
```json
{
  "email": "john@example.com",
  "password": "secretpassword"
}
```
- **Validation Rules**:
  - `email`: required | email
  - `password`: required
- **Response (200 OK)**:
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "2|sanctum_token_string_here"
}
```

### Logout User
- **Endpoint**: `POST /logout`
- **Authentication**: Bearer Token
- **Response (200 OK)**:
```json
{
  "message": "Logout successful"
}
```

### Check Email Availability
- **Endpoint**: `POST /check-email`
- **Authentication**: None required
- **Request Body**:
```json
{
  "email": "john@example.com"
}
```
- **Validation Rules**:
  - `email`: required | email
- **Response - Registered Email (200 OK)**:
```json
{
  "exists": true
}
```
- **Response - Available Email (200 OK)**:
```json
{
  "exists": false
}
```
- **Response - Validation Error (422 Unprocessable Entity)**:
```json
{
  "message": "The email field is required.",
  "errors": {
    "email": [
      "The email field must be a valid email address."
    ]
  }
}
```

---

## 2. User Profile & Sub-collections

### Get Complete Authenticated Profile
- **Endpoint**: `GET /user/profile`
- **Authentication**: Bearer Token
- **Response (200 OK)**:
```json
{
  "message": "Profile retrieved successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2026-09-17T07:00:00.000000Z",
      "updated_at": "2026-09-17T07:00:00.000000Z"
    },
    "profile": {
      "id": 1,
      "user_id": 1,
      "role": "Student",
      "current_status": "8th Semester",
      "affiliated_organization": "NCCS",
      "date_of_birth": "2000-05-15",
      "phone": "+977 9800000000",
      "description": "Software Engineering Student & Developer",
      "location": "Kathmandu, Nepal",
      "profile_image": "https://example.com/images/profile.jpg",
      "created_at": "2026-09-17T07:00:00.000000Z",
      "updated_at": "2026-09-17T07:00:00.000000Z"
    },
    "academic_qualifications": [
      {
        "id": 1,
        "user_id": 1,
        "degree": "BSc Computer Science",
        "institution": "Tribhuvan University",
        "field": "Software Engineering",
        "start_date": "2022-09-01",
        "end_date": "2026-08-31"
      }
    ],
    "experiences": [
      {
        "id": 1,
        "user_id": 1,
        "organization": "ABC Technologies",
        "position": "Flutter Intern",
        "description": "Mobile application development",
        "start_date": "2025-01-01",
        "end_date": null,
        "is_current": true
      }
    ],
    "skills": [
      {
        "id": 1,
        "user_id": 1,
        "name": "Flutter"
      }
    ],
    "projects": [
      {
        "id": 1,
        "user_id": 1,
        "title": "Smart Wardrobe App",
        "description": "Mobile app built with Flutter and Laravel",
        "link": "https://github.com/user/project"
      }
    ],
    "achievements": [
      {
        "id": 1,
        "user_id": 1,
        "title": "Hackathon Winner 2025",
        "description": "First place in Mobile App Track",
        "date": "2025-06-15"
      }
    ],
    "courseworks": [
      {
        "id": 1,
        "user_id": 1,
        "name": "Mobile Application Development",
        "description": "Advanced iOS & Android dev with Flutter"
      }
    ],
    "interests": [
      {
        "id": 1,
        "user_id": 1,
        "name": "Open Source Development"
      }
    ]
  }
}
```

> [!NOTE]
> If a newly registered user has not created any entries yet, `profile` will be `null` and all list collections will be empty arrays `[]`.

---

### Update Profile
- **Endpoint**: `PUT /user/profile`
- **Authentication**: Bearer Token
- **Request Body**:
```json
{
  "role": "Student",
  "current_status": "8th Semester",
  "affiliated_organization": "NCCS",
  "date_of_birth": "2000-05-15",
  "phone": "+977 9800000000",
  "description": "Flutter developer passionate about UI/UX.",
  "location": "Kathmandu, Nepal",
  "profile_image": "https://example.com/avatar.png"
}
```
- **Validation Rules**:
  - `role`: nullable | string | max:255
  - `current_status`: nullable | string | max:255
  - `affiliated_organization`: nullable | string | max:255
  - `date_of_birth`: nullable | date (`YYYY-MM-DD`)
  - `phone`: nullable | string | max:50
  - `description`: nullable | string
  - `location`: nullable | string | max:255
  - `profile_image`: nullable | string | max:500
- **Response (200 OK)**:
```json
{
  "message": "Profile updated successfully",
  "data": { ... }
}
```

---

## 3. Academic Qualifications CRUD

- **Get List**: `GET /user/academic-qualifications`
- **Create**: `POST /user/academic-qualifications` (Returns 201 Created)
- **Update**: `PUT /user/academic-qualifications/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/academic-qualifications/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "degree": "Bachelor in Computer Science",
  "institution": "Tribhuvan University",
  "field": "Information Technology",
  "start_date": "2022-09-01",
  "end_date": "2026-08-31"
}
```
### Validation Rules:
- `degree`: required | string | max:255
- `institution`: required | string | max:255
- `field`: nullable | string | max:255
- `start_date`: nullable | date
- `end_date`: nullable | date

---

## 4. Experiences CRUD

- **Get List**: `GET /user/experiences`
- **Create**: `POST /user/experiences` (Returns 201 Created)
- **Update**: `PUT /user/experiences/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/experiences/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "organization": "ABC Technologies",
  "position": "Software Developer Intern",
  "description": "Building REST APIs in Laravel & Mobile UIs in Flutter",
  "start_date": "2025-01-01",
  "end_date": null,
  "is_current": true
}
```
### Validation Rules:
- `organization`: required | string | max:255
- `position`: required | string | max:255
- `description`: nullable | string
- `start_date`: nullable | date
- `end_date`: nullable | date (Pass `null` when `is_current` is `true`)
- `is_current`: nullable | boolean

---

## 5. Skills CRUD

- **Get List**: `GET /user/skills`
- **Create**: `POST /user/skills` (Returns 201 Created)
- **Update**: `PUT /user/skills/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/skills/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "name": "Flutter & Dart"
}
```
### Validation Rules:
- `name`: required | string | max:255

---

## 6. Projects CRUD

- **Get List**: `GET /user/projects`
- **Create**: `POST /user/projects` (Returns 201 Created)
- **Update**: `PUT /user/projects/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/projects/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "title": "Smart Wardrobe App",
  "description": "AI-assisted wardrobe styling mobile application.",
  "link": "https://github.com/user/smart-wardrobe"
}
```
### Validation Rules:
- `title`: required | string | max:255
- `description`: nullable | string
- `link`: nullable | string | max:500

---

## 7. Achievements CRUD

- **Get List**: `GET /user/achievements`
- **Create**: `POST /user/achievements` (Returns 201 Created)
- **Update**: `PUT /user/achievements/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/achievements/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "title": "Best Mobile App Award",
  "description": "Won 1st place in regional app dev hackathon",
  "date": "2025-05-10"
}
```
### Validation Rules:
- `title`: required | string | max:255
- `description`: nullable | string
- `date`: nullable | date

---

## 8. Courseworks CRUD

- **Get List**: `GET /user/courseworks`
- **Create**: `POST /user/courseworks` (Returns 201 Created)
- **Update**: `PUT /user/courseworks/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/courseworks/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "name": "Database Management Systems",
  "description": "Relational DB design, normalization, indexing and SQL optimization"
}
```
### Validation Rules:
- `name`: required | string | max:255
- `description`: nullable | string

---

## 9. Interests CRUD

- **Get List**: `GET /user/interests`
- **Create**: `POST /user/interests` (Returns 201 Created)
- **Update**: `PUT /user/interests/{id}` (Returns 200 OK)
- **Delete**: `DELETE /user/interests/{id}` (Returns 200 OK)

### Request Body (Create / Update):
```json
{
  "name": "Machine Learning & AI"
}
```
### Validation Rules:
- `name`: required | string | max:255

---

## HTTP Status Codes Summary
- `200 OK`: Request succeeded (GET, PUT, DELETE)
- `201 Created`: Resource successfully created (POST)
- `401 Unauthorized`: Unauthenticated / invalid or missing Sanctum token
- `404 Not Found`: Resource ID does not exist or does not belong to the user
- `422 Unprocessable Entity`: Validation failed for input parameters
