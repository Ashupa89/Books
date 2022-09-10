
### Installation

_Below you can follow these steps to install and set up this app._

1. Clone the repo
   ```sh
   git clone https://github.com/Ashupa89/Books.git
   ```
2. Update Composer
   ```sh
    composer update
   ```
3. Create database books
   ```sh
    Create DATABASE book
   ``` 
4. do migrate
    ```sh
    php artisan migarte
    ```     
5. Install NPM packages
   ```sh
   npm install
   ```
6. Run this command
   ```sh
   npm run watch 
   ```
7. Run this command
   ```sh
   php artisan serve 
   ```
8.  Open on browser 
   ```sh
   127.0.0.1:8000/login 
   ```
#### Login Credentials ####
Admin
-
email - admin@gmail.com

password - admin

Customer  
-------
email - user@gmail.com

password - user

---

### API Implementation
 

 Register Customer
   ```sh
      POST - 127.0.0.1:8000/api/register
   ```
 Login API for Admin/Customer
   ```sh
      POST - 127.0.0.1:8000/api/login
   ```
 List of the available book based on search API
  ```sh
     GET - 127.0.0.1:8000/api/books
  ```
 Add Book API
  ```sh
     POST - 127.0.0.1:8000/api/books/add
   ```
 Edit Book API
 ```sh
    GET - 127.0.0.1:8000/api/books/edit/1
 ```
 Update Book API
 ```sh
    GET - 127.0.0.1:8000/api/books/update/1
 ```   
 Delete Book API
 ```sh
    DELETE - 127.0.0.1:8000/api/books/delete/1
 ```   
View Book Information API
 ```sh
    GET - 127.0.0.1:8000/api/books/view/1
 ```
 #### To API on Postman 
 First generate token by login 
 put into the authorization Bearer token 


<p align="right">(<a href="#readme-top">back to top</a>)</p>
