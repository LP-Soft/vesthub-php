# Vesthub - E-Estate Agency Website

<p align="center">
<img src="https://github.com/user-attachments/assets/251c95d0-0ada-4e00-a809-a0bae540a566" alt="Wallet" width="200" height="200">
</p>

Vesthub is a comprehensive real estate listing platform that connects property owners/agents with potential buyers and renters. Built with PHP and MySQL, it provides an intuitive interface for property listing, searching, and management.

## Detailed User Roles and Capabilities

### Regular Users (Property Seekers)

#### Account Management
* Create and manage personal profiles
* Update contact information and preferences
* Two-factor authentication for enhanced security
* Password reset functionality

<img src="https://github.com/user-attachments/assets/f377691a-280a-48ed-abd4-361795f14e8d" alt="Wallet">

<img src="https://github.com/user-attachments/assets/48bf9865-27e3-4e8d-85e6-d98157d92146" alt="Wallet">

<img src="https://github.com/user-attachments/assets/aac6888a-8d1b-4b2d-a97c-aa902de87de7" alt="Wallet">

#### Property Search Features
* Advanced filtering system by:
  * Location (City, District, Neighborhood)
  * Price range
  * Property type (Villa, Apartment, Studio)
  * Number of rooms
  * Floor preferences
  * Specific amenities
* Sort results by price (ascending/descending)
* View property locations on interactive maps

<img src="https://github.com/user-attachments/assets/db28c018-9292-4ee9-8060-32cad7311465" alt="Wallet">

<img src="https://github.com/user-attachments/assets/afb20a4c-6ee4-44d0-9018-7251743573eb" alt="Wallet">

#### Property Interaction
* Save favorite properties for later viewing
* Access detailed property information including:
  * High-resolution images
  * Floor plans
  * Amenity lists
  * Location details
  * Contact information for owners/agents
* View property status (Available, Sold, Rented)
* Direct contact with property owners/agents via provided contact information

<img src="https://github.com/user-attachments/assets/059d7aac-7bc0-4e2a-b370-b6d6b9edf6bd" alt="Wallet">

<img src="https://github.com/user-attachments/assets/a577d523-d445-4263-9c30-04e3e7892ceb" alt="Wallet">


## Property Owners/Agents

### Listing Management
* Create detailed property listings with:
  * Multiple high-quality images
  * Comprehensive property descriptions
  * Precise location information
  * Price and payment terms
  * Property specifications
  * Available amenities
* Edit existing listings
* Mark properties as sold/rented
* Remove listings when necessary
* Track listing status (Pending, Approved, Rejected)

<img src="https://github.com/user-attachments/assets/9e224455-0be6-49d9-85eb-b7f421368be8" alt="Wallet">

<img src="https://github.com/user-attachments/assets/74a2d020-c8cb-48c8-ad6e-2ad814ceaaf8" alt="Wallet">

<img src="https://github.com/user-attachments/assets/97beeb26-d96e-4758-bd40-c5b2f0f699b5" alt="Wallet">


### Account Features
* Professional profile management
* Contact information visibility control
* Listing activity monitoring
* Email notifications for:
  * Listing approval/rejection
  * Status changes
  * System updates

## Administrators

### Content Management
* Review, approve or reject new property listings
* Monitor content quality and accuracy
* Remove inappropriate content
* Manage featured listings

<img src="https://github.com/user-attachments/assets/9b2ec086-2ce5-4941-a049-7fd384ae64ca" alt="Wallet">

## Project Contributors

<img src="https://github.com/user-attachments/assets/38ffe851-61e9-473d-863e-d07426c07e06" alt="Wallet">

## Project Demo Video

<a href="https://drive.google.com/file/d/1TpWZK6NAbH_qz8BNtGnzFrFeu14WZTn0/view?usp=drive_link" target="_blank">Click Here to Reach the Project Demo Video</a>

## Technical Features and Properties

### Security Implementation

#### User Authentication
* Secure password hashing using modern algorithms
* Two-factor authentication via email
* Session management and timeout

#### Data Protection
* Input validation and sanitization
* SQL injection protection
* Encrypted data storage

## Database Architecture

### Optimized Schema Design
* Normalized tables for efficient data storage
* Indexed fields for faster searches
* Proper foreign key relationships
* Structured data organization

## Integration Features

### Google Maps Integration
* Interactive property location mapping
* Geocoding for address validation
* Distance calculation
* Area visualization

## System Requirements and Dependencies

### Server Requirements
* **PHP 7.4 or higher**
  * Required Extensions:
    * PDO PHP Extension
    * MySQL PHP Extension
    * GD PHP Extension for image processing
    * OpenSSL PHP Extension
* **MySQL 8.0.39 or higher**
* **Apache/Nginx web server**
* Minimum **2GB RAM**
* **10GB storage space** (recommended)

### Client Requirements
* Modern web browser (Chrome, Firefox, Safari, Edge)
* JavaScript enabled
* Cookies enabled
* Minimum screen resolution: **1024x768**

## Notes:
### To Run The Project on Phpstorm:
* Be ensure that you have downloaded PHP and add it as CLI interpreter
* Follow the steps to download PHP: https://www.geeksforgeeks.org/how-to-install-php-in-windows-10/
* Click Edit Configurations at the right-top 
* Click + button at the left-top and create PHP Built-in Web Server, name it whatever you want for instance "Vesthub"
* Document root should be C:\Users\Monster\Desktop\Safak\Vesthub\vesthub-php\Frontend\Pages 
* Click apply and ok
* Go to that direction C:\Users\Monster\Desktop\Safak\Vesthub\vesthub-php> 
* Enter php -S localhost:8000 to open the port
* Run the project ("Vesthub") at the right top on the server localhost:8080
* Enter http://localhost:8000 and it will direct you to http://localhost:8000/Frontend/Pages/aboutPage.php
* Default page is aboutPage.php for now
