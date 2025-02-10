# Vesthub - E-Estate Agency Website

Vesthub is a comprehensive real estate listing platform that connects property owners/agents with potential buyers and renters. Built with PHP and MySQL, it provides an intuitive interface for property listing, searching, and management.

## Detailed User Roles and Capabilities

### Regular Users (Property Seekers)

#### Account Management
* Create and manage personal profiles
* Update contact information and preferences
* Two-factor authentication for enhanced security
* Password reset functionality

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
* Review and approve new property listings
* Monitor content quality and accuracy
* Remove inappropriate content
* Manage featured listings

### User Management
* Review user accounts
* Handle user reports and complaints
* Moderate user activities
* Manage user access levels

### System Oversight
* Monitor system performance
* Track user activities
* Generate usage reports
* Maintain system integrity

## Technical Features and Properties

### Security Implementation

#### User Authentication
* Secure password hashing using modern algorithms
* Two-factor authentication via email
* Session management and timeout
* CSRF protection

#### Data Protection
* Input validation and sanitization
* XSS prevention
* SQL injection protection
* Encrypted data storage

## Database Architecture

### Optimized Schema Design
* Normalized tables for efficient data storage
* Indexed fields for faster searches
* Proper foreign key relationships
* Structured data organization

## Performance Features

### Optimization Techniques
* Caching system for frequent queries
* Optimized image storage and delivery
* Efficient search algorithms
* Pagination for large result sets

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


# vesthub-php
### To run the project on phpstorm:
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
