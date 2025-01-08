<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# WriteWave App

This repository contains a **WriteWave App** API built with **Laravel**. The API allows users to create, read, update, and delete blogs, manage images, and handle validation seamlessly.

---

## 🚀 Features

- **Blog Listing**: Fetch all blogs with optional keyword search.
- **View Blog Details**: Retrieve a specific blog by ID.
- **Create Blog**: Add new blogs with associated metadata and image handling.
- **Update Blog**: Edit blog details and update associated images.
- **Delete Blog**: Remove a blog and its associated image from the system.

---

## 📂 API Endpoints

### Public Endpoints

1. **Fetch All Blogs**
   - **URL**: `/api/blogs`
   - **Method**: `GET`
   - **Query Parameters**:
     - `keyword` (optional): Search blogs by title.
   - **Response**: List of blogs.

2. **View Blog Details**
   - **URL**: `/api/blogs/{id}`
   - **Method**: `GET`
   - **Response**: Details of the blog or a `404` message if not found.

---

### Protected Endpoints

1. **Create Blog**
   - **URL**: `/api/blogs`
   - **Method**: `POST`
   - **Request Parameters**:
     - `title`: Blog title (required, min: 4 characters).
     - `author`: Blog author (required, min: 3 characters).
     - `description`: Blog description (optional).
     - `shortDesc`: Short description (optional).
     - `image_id`: ID of the temporary image (optional).
   - **Response**: Success message and blog details.

2. **Update Blog**
   - **URL**: `/api/blogs/{id}`
   - **Method**: `PUT`
   - **Request Parameters**:
     - `title`: Blog title (required, min: 4 characters).
     - `author`: Blog author (required, min: 3 characters).
     - `description`: Blog description (optional).
     - `shortDesc`: Short description (optional).
     - `image_id`: ID of the temporary image (optional).
   - **Response**: Success message and updated blog details.

3. **Delete Blog**
   - **URL**: `/api/blogs/{id}`
   - **Method**: `DELETE`
   - **Response**: Success message or `404` message if the blog is not found.

---

## 🛠 Image Management

- Temporary images are uploaded and stored in `uploads/temp`.
- Images are moved to `uploads/temp/blogs` upon blog creation or update.
- Images are deleted from storage when a blog is deleted.

---

## 🛡 Validation Rules

- **Title**: Required, minimum 4 characters.
- **Author**: Required, minimum 3 characters.
- Validation errors return a response with `status: false` and a list of errors.

---

## 📋 Controller Methods

### `index()`
- Retrieves a list of blogs, optionally filtered by a keyword.
- **Response**: JSON containing blog data.

### `show($id)`
- Fetches details of a specific blog by ID.
- **Response**: Blog data or error message if not found.

### `store(Request $request)`
- Validates input and creates a new blog.
- Handles image assignment from temporary storage.
- **Response**: Created blog data or validation errors.

### `update($id, Request $request)`
- Validates input and updates an existing blog.
- Handles new image assignment from temporary storage.
- **Response**: Updated blog data or error messages.

### `destroy($id)`
- Deletes a blog and removes its associated image.
- **Response**: Success or error message.
