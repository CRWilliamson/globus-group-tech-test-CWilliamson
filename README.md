# Laravel Application

## Overview

This is a fresh Laravel application that will be used to manage the Globus Technical Challenge.

## Installation

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Run `npx vite`

## Notes
- Please note that .env has been updated with a new DB_DATABASE
- To run tests on a fresh version of this project, you may need to run `php artisan config:cache` and `php artisan cache:clear`. You can then run `php artisan test`

## Summary of changes
- Migrations created for DB tables
    - This includes a pivot table for the products and categories. The `product_id` and `category_id` fields are unique and indexed
    - Note: I learned that MySQL and Mariadb automatically index foreign keys where it can, so fields like `product_type_id` and `status_id` in the products table were already indexed after migration
- `php artisan ImportProducts` command created that reads the JSON file in `storage/app/private` and populates DB tables with it.
- API set up on project
    - `/products` - Gets all products in the DB with relations eager loaded
    - `/products/{id}` - Gets a specific product
    - `/categories/{id}/products` - Gets the products relationship against a specific category
    - `/status/{id}/products` - Gets the products relationship against a specific status
    - `/productType/{id}/products` - Gets the products relationship against a specific product type
    - Each model is given its own controller, but reusable querying code is abstractd away to repository classes. This has the added benefit of unit testing controllers becoming simpler by not needing to mock eloquent relations.

- Unit and feature tests written to assert endpoints return correct responses
- Front end has been updated to run the API calls using Axios. The category pages filter products by category, and the new products page filters by status. Data is paginated. Product relations are eager loaded. The product name and one of the images from a variation is shown.

## Considerations
- I ended up treating the product images as a more generic 'files' model. Realistically, files could be related to multiple tables which might call for a morph relationship, but belongsTo Variations is sufficient for this use case.
- Since this project is a sort of snapshot of a real shopping site, some auth handling so that only authenticated users could fetch the data would make this more secure
- I considered allowing relations to be passed into the API as query params or a payload, but I decided that a user should not be allowed to decide how much data an endpoint should return. Instead, relations are passed in from the controller function to the repository. If we ever did want different relations being returned, we would have to create the endpoints and controller functions for it. The repository functions are reusable.
    - In hindsight, there is an additional use case where being able to pass in relations could allow filtering to be driven through a single endpoint without the need to return the relation data.
- There is room for more error handling and validation, which would have been included with more time
