# BikeHub - Professional Bike Rental System

**Live Demo:** http://localhost:8000  
**API Base URL:** http://localhost:8000/api  
**Version:** 1.0.0  
**Status:**  Production Ready


## Project Overview

BikeHub is an enterprise-level bike rental management system demonstrating professional PHP development practices.
## Note: The project has been developed using the MVC (Model-View-Controller) architecture, ensuring a clean, structured, and maintainable codebase.

**What This Project Does:**
- Manages a inventory of rental bikes
- Provides advanced search, filtering, and sorting capabilities
- Delivers a responsive, modern user interface
- Exposes comprehensive REST API for integration
- Handles pagination for large datasets
- Supports complex query combinations

**Use Cases:**
- Small to medium bike rental businesses
- API for mobile apps and third-party integrations
- Educational reference for clean code architecture
- Starting point for larger rental management systems

---

## Key Features

###  User Interface

- **Responsive Dashboard** - Works on desktop, tablet, and mobile
- **Advanced Search** - Find bikes by name, type, or description
- **Multi-criteria Filtering**:
  - Bike type (Mountain, Road, Cruiser, Hybrid, BMX, Electric)
  - Price range (min/max)
  - Availability status
  - Sorting by name, price, or type
  - Ascending/Descending order
- **Smart Pagination** - 10 bikes per page with navigation controls
- **Empty State Handling** - Friendly messages when no results found
- **Professional Design** - Modern UI with Bootstrap 5.3
- **Loading Indicators** - Visual feedback for user actions

### Data Management

- **15 Realistic Bikes** - Diverse inventory with realistic data
- **Type-Safe Models** - PHP Bike model with typed properties
- **Query Builder Pattern** - Chainable query methods
- **Advanced Filtering** - Multiple independent filters
- **Sorting** - By name, price, or type in both directions
- **Pagination** - Configurable items per page
- **Search Algorithm** - Full-text search across multiple fields

### API Layer

- **REST Endpoints** - GET /api/bikes with comprehensive querying
- **Query Parameters** - Flexible filtering and sorting
- **Pagination** - Metadata-rich response format
- **JSON Responses** - Consistent response structure
- **Error Handling** - Proper HTTP status codes
- **Documentation** - Complete API reference

### Architecture

- **MVC Pattern** - Clean separation of concerns
- **Repository Pattern** - Data access abstraction
- **Service Layer** - Business logic encapsulation
- **Dependency Injection** - Loose coupling throughout
- **SOLID Principles** - Professional code organization
- **PSR-4 Autoloading** - Modern PHP standards

### Code Quality

- **No Code Duplication** - DRY principle throughout
- **Clean Code** - Meaningful names and single responsibility
- **Type Hints** - Full type safety in PHP 8.2+
- **Error Handling** - Proper exception management
- **Input Validation** - Comprehensive validation layer
- **Code Documentation** - Inline comments for complex logic


### Backend
- **Language:** PHP 8.2+
- **Autoloading:** Composer with PSR-4
- **Framework:** Custom lightweight MVC framework
- **Architecture:** Repository Pattern, Service Layer, Query Builder

### Frontend
- **HTML5:** Semantic markup
- **CSS:** Bootstrap 5.3.3 (CDN)
- **JavaScript:** Vanilla JS with no dependencies
- **Icons:** Bootstrap Icons (CDN)
- **Design:** Mobile-first responsive design

### Development Tools
- **Package Manager:** Composer
- **Version Control:** Git
- **Web Server:** PHP Built-in server (development)
- **Testing:** Manual API testing with curl

## AI Tool Used:

- **ChatGPT
- **GitHub Copilot (Visual Studio Code Extension)


### 2. **Repository Pattern**

**Purpose:** Abstract data access logic from business logic

**Benefits:**
- Easy to swap implementations (in-memory → database)
- Testable with mock repositories
- Centralized data access logic
- Clear data access contract

### 3. **Query Builder Pattern**
**Purpose:** Build complex queries with chainable methods

**Methods:**
- `filterByType($type)` - Filter by bike type
- `filterByPriceRange($min, $max)` - Filter by price range
- `filterByAvailability($available)` - Filter by availability
- `searchByName($term)` - Search by name, type, description
- `sortBy($column, $direction)` - Sort results
- `paginate($page, $perPage)` - Paginate results
- `get()` - Execute and return results



## Project Structure

```
BikeRentalAssessmentReady/
│
├── app/
│   ├── Controllers/
│   │   ├── BikeController.php      # API endpoints
│   │   └── HomeController.php      # HTML page rendering
│   │
│   ├── Services/
│   │   └── BikeService.php         # Business logic layer
│   │
│   ├── Repositories/
│   │   └── BikeRepository.php      # Data access layer (15 bikes)
│   │
│   ├── Interfaces/
│   │   ├── BikeRepositoryInterface.php  # Repository contract
│   │   └── BikeQueryBuilder.php         # Query builder contract
│   │
│   ├── Models/
│   │   └── Bike.php               # Bike model with typed properties
│   │
│   ├── Enums/
│   │   └── BikeType.php           # Type-safe bike types
│   │
│   ├── Core/
│   │   ├── Request.php            # HTTP request parsing
│   │   ├── Response.php           # HTTP response building
│   │   └── Router.php             # Route matching and dispatch
│   │
│   └── Helpers/
│       ├── PaginationHelper.php   # Pagination utilities
│       ├── StringHelper.php       # String manipulation
│       └── ValidationHelper.php   # Input validation
│
├── config/
│   └── app.php                    # Application configuration
│
├── routes/
│   └── api.php                    # Route definitions
│
├── views/
│   ├── layouts/
│   │   └── main.php               # Master template
│   └── bikes/
│       ├── index.php              # Bike listing page
│       └── details.php            # Single bike details
│
├── public/
│   ├── index.php                  # Application entry point
│   └── assets/
│       ├── css/
│       │   └── style.css          # Custom styles
│       ├── js/
│       │   └── app.js             # Client-side JS
│       └── images/                # Image assets
│
├── vendor/                        # Composer dependencies
│
├── composer.json                  # Project manifest
├── README.md                      # This file
│
└── .gitignore                     # Git ignore rules
```

---

## Installation & Setup
- PHP 8.2 or higher
- Composer
- Git
- Command-line terminal

### Step 1: Clone/Setup Project

```bash
# Navigate to project directory
cd /home/sonalraj/Projects/BikeRentalAssessmentReady

# Install dependencies
composer install

# Verify installation
composer show
```

### Step 2: Configure Application

### Step 3: Run Application

**Using PHP Built-in Server:**

```bash
# Navigate to project root
cd /home/sonalraj/Projects/BikeRentalAssessmentReady

# Start server on port 8000
php -S localhost:8000 -t public

```bash
# Test HTML interface
curl http://localhost:8000

# Test API
curl http://localhost:8000/api/bikes
```
