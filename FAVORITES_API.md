# Favorites API Documentation

## Overview

The Favorites system allows users to add products to their favorites list, view their favorites, and manage their favorite products. The system also provides a way to check if a product is favorited by the current user, which is useful for showing a red heart icon in the frontend.

## Database Relationships

The system uses a many-to-many relationship between Users and Products through the `favorites` table:

-   `User` has many `Product` (favorites) through `favorites` table
-   `Product` has many `User` (favoritedBy) through `favorites` table

## API Endpoints

### 1. Add Product to Favorites

**POST** `/api/favorites/{product}/add`

Adds a specific product to the authenticated user's favorites.

**Parameters:**

-   `product` (route parameter): Product ID

**Response:**

```json
{
    "success": true,
    "message": "Product added to favorites successfully",
    "status_code": 201
}
```

**Error Response (if already favorited):**

```json
{
    "success": false,
    "message": "Product is already in favorites",
    "status_code": 409
}
```

### 2. Remove Product from Favorites

**DELETE** `/api/favorites/{product}/remove`

Removes a specific product from the authenticated user's favorites.

**Parameters:**

-   `product` (route parameter): Product ID

**Response:**

```json
{
    "success": true,
    "message": "Product removed from favorites successfully",
    "status_code": 200
}
```

**Error Response (if not favorited):**

```json
{
    "success": false,
    "message": "Product is not in favorites",
    "status_code": 404
}
```

### 3. Get User's Favorites

**GET** `/api/favorites/list`

Retrieves all favorite products for the authenticated user with pagination.

**Query Parameters:**

-   `per_page` (optional): Number of items per page (default: 10)

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Product Name",
            "price": 100.0,
            "description": "Product description",
            "available_quantity": 10,
            "is_favorited": true,
            "category": "Category Name",
            "color": "Color Name",
            "fabric": "Fabric Type",
            "wood": "Wood Type"
        }
    ],
    "message": "Favorites retrieved successfully",
    "status_code": 200
}
```

### 4. Check Favorite Status

**GET** `/api/favorites/{product}/check`

Checks if a specific product is favorited by the authenticated user.

**Parameters:**

-   `product` (route parameter): Product ID

**Response:**

```json
{
    "success": true,
    "data": {
        "is_favorited": true
    },
    "message": "Favorite status retrieved successfully",
    "status_code": 200
}
```

### 5. Toggle Favorite Status

**POST** `/api/favorites/{product}/toggle`

Toggles the favorite status of a product (adds if not favorited, removes if favorited).

**Parameters:**

-   `product` (route parameter): Product ID

**Response:**

```json
{
    "success": true,
    "data": {
        "is_favorited": true,
        "message": "Product added to favorites"
    },
    "message": "Product added to favorites",
    "status_code": 201
}
```

## Frontend Integration

### Showing Red Heart for Favorited Products

When displaying products in the frontend (home page, search results, category pages), each product will include an `is_favorited` field:

```json
{
    "id": 1,
    "name": "Product Name",
    "price": 100.0,
    "is_favorited": true // This field indicates if the product is favorited
    // ... other product fields
}
```

**Frontend Implementation Example:**

```javascript
// React/Vue/Angular example
function ProductCard({ product }) {
    return (
        <div className="product-card">
            <img src={product.image} alt={product.name} />
            <h3>{product.name}</h3>
            <p>${product.price}</p>

            {/* Show red heart if favorited, empty heart if not */}
            <button
                className={`favorite-btn ${
                    product.is_favorited ? "favorited" : ""
                }`}
                onClick={() => toggleFavorite(product.id)}
            >
                {product.is_favorited ? "❤️" : "🤍"}
            </button>
        </div>
    );
}
```

**CSS Example:**

```css
.favorite-btn {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 20px;
}

.favorite-btn.favorited {
    color: red;
}
```

## Authentication

All favorites endpoints require authentication. Users must be logged in to:

-   Add products to favorites
-   Remove products from favorites
-   View their favorites list
-   Check favorite status

For non-authenticated users viewing products, the `is_favorited` field will always be `false`.

## Error Handling

The API returns appropriate HTTP status codes:

-   `200`: Success
-   `201`: Created (product added to favorites)
-   `401`: Unauthorized (user not authenticated)
-   `404`: Not Found (product not in favorites)
-   `409`: Conflict (product already in favorites)

## Additional Features

### Bulk Operations

The `FavoriteService` also includes methods for bulk operations:

-   `bulkAddToFavorites()`: Add multiple products at once
-   `bulkRemoveFromFavorites()`: Remove multiple products at once

### Statistics

-   `getUserFavoriteCount()`: Get total number of user's favorites
-   `getProductFavoriteCount()`: Get total number of users who favorited a product

## Database Schema

```sql
-- favorites table
CREATE TABLE favorites (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    UNIQUE KEY unique_user_product (user_id, product_id)
);
```

The system ensures that a user cannot add the same product to favorites multiple times through the unique constraint on `user_id` and `product_id`.
