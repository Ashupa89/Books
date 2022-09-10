
### Installation

_Below you can follow these steps to install and set up this app._

 Clone the repo
   ```sh
   git clone https://github.com/Ashupa89/Books.git
   ```
 Go to
   ```
    cd Books
   ``` 
 Update Composer
   ```sh
    composer update
   ```
 Create database books
   ```sh
    Create DATABASE book
   ``` 
 do migrate
    ```sh
    php artisan migarte
    ```     
 Install NPM packages
   ```sh
   npm install
   ```
 Run this command
   ```sh
   npm run watch 
   ```
 Run this command
   ```sh
   php artisan serve 
   ```
 Open on browser 
    ```sh
    127.0.0.1:8000/login 
    ```
# Login Credentials 
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
like below image
![token passing](https://user-images.githubusercontent.com/37969982/189473869-4c5605e0-1b2a-40b7-9c98-83c3ec0b79e1.png)

## some images for references

![login](https://user-images.githubusercontent.com/37969982/189473921-324ad283-9651-4617-b80c-96084025656d.png)

![register](https://user-images.githubusercontent.com/37969982/189473922-9cfb6ad9-e932-4480-9fb7-39c63904ff7e.png)

![books-get](https://user-images.githubusercontent.com/37969982/189473919-96f6b80d-00e3-4997-8e02-893491d42fed.png)

![update-validation-failed](https://user-images.githubusercontent.com/37969982/189473914-74424707-e5b6-4c57-806b-93eab9d2551e.png)

![book -add](https://user-images.githubusercontent.com/37969982/189473916-d6743b29-59d7-4898-84cb-e05a34a34595.png)

![book-edit](https://user-images.githubusercontent.com/37969982/189473918-924ed309-9cbd-4438-8699-2b54f8e57c44.png)

![book-update](https://user-images.githubusercontent.com/37969982/189473920-578c3d29-052a-4af4-814c-5ff95dcfd8bd.png)

![book-delete](https://user-images.githubusercontent.com/37969982/189473917-f0371548-3c34-470a-aae3-a723e20d4233.png)

![Screenshot 2022-09-10 114340](https://user-images.githubusercontent.com/37969982/189473923-ad17a99a-0bcb-488c-8f8b-38185dddb179.png)


<p align="right">(<a href="#readme-top">back to top</a>)</p>

