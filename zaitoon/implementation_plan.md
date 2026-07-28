# Implementation Plan - Nagorik Sheba

## Goal
Build a comprehensive **Local Service Directory** for Sirajganj, Bangladesh.
The system will be a **Mobile-First Web Application** using **Laravel (Blade)**, **Tailwind CSS**, and **Alpine.js**.
It features a hierarchical category system (Super -> Main -> Child), dynamic listing attributes (Doctors, Vehicles, etc.), and a custom Admin Dashboard.

## User Review Required
> [!IMPORTANT]
> **Tech Stack Confirmation**: The plan assumes the use of the existing **Laravel** project structure found in the directory.
> **Database**: Development will use **SQLite** (default for Laravel) or MySQL if available.
> **Admin Panel**: A **Custom Admin Panel** will be built (no Filament) as requested.

## Proposed Changes

### 1. Database & Models
Refine the existing schema to fully support the requirements.

#### [MODIFY] [2025_11_19_175319_create_categories_table.php](file:///home/ticktick/Desktop/nagorik-sheba/database/migrations/2025_11_19_175319_create_categories_table.php)
- Ensure `parent_id` is used effectively for the 3-level hierarchy:
    - **Level 1 (Super)**: Health, Transport, etc. (parent_id = null)
    - **Level 2 (Main)**: Doctor, Hospital, Bus, etc. (parent_id = Super)
    - **Level 3 (Child)**: Cardiologist, Ambulance, etc. (parent_id = Main)

#### [MODIFY] [2025_11_19_175319_create_services_table.php](file:///home/ticktick/Desktop/nagorik-sheba/database/migrations/2025_11_19_175319_create_services_table.php)
- Utilize `meta_data` (JSON) to store category-specific fields:
    - **Doctor**: `specialty`, `degree`, `chamber_address`, `visiting_hours`
    - **Vehicle**: `driver_name`, `seat_capacity`, `vehicle_model`
    - **Restaurant**: `menu_images`, `opening_hours`
- Ensure `status` column manages the approval workflow (`pending`, `approved`, `rejected`).

### 2. Backend Logic (Laravel)
Implement the core logic for data retrieval and management.

#### [NEW] [ServiceRepository.php](file:///home/ticktick/Desktop/nagorik-sheba/app/Repositories/ServiceRepository.php)
- Handle filtering services by category, location, and search query.
- Handle `meta_data` saving and retrieval.

#### [MODIFY] [HomeController.php](file:///home/ticktick/Desktop/nagorik-sheba/app/Http/Controllers/Frontend/HomeController.php)
- Fetch `Super Categories` with their `Main Categories` for the homepage sections.

#### [MODIFY] [ServiceController.php](file:///home/ticktick/Desktop/nagorik-sheba/app/Http/Controllers/Frontend/ServiceController.php)
- `show()` method should pass the service and its specific `meta_data` to the view.

### 3. Frontend (Blade + Tailwind)
Build the public-facing pages with a premium, mobile-first design.

#### [MODIFY] [home.blade.php](file:///home/ticktick/Desktop/nagorik-sheba/resources/views/home.blade.php)
- Update loop to render **Super Category Sections**.
- Inside each section, render a Grid of **Main Category Cards**.

#### [NEW] [service/show.blade.php](file:///home/ticktick/Desktop/nagorik-sheba/resources/views/frontend/services/show.blade.php)
- A dynamic detail page that adapts based on the service type.
- Display `meta_data` fields nicely (e.g., a table for Doctor schedules, a list for Vehicle features).
- "Call Now" and "Message" sticky buttons for mobile.

#### [NEW] [category/show.blade.php](file:///home/ticktick/Desktop/nagorik-sheba/resources/views/frontend/category/show.blade.php)
- List services within a category.
- Filter options (if needed).

### 4. Admin Panel (Custom)
Build a lightweight, secure admin dashboard.

#### [MODIFY] [Admin/DashboardController.php](file:///home/ticktick/Desktop/nagorik-sheba/app/Http/Controllers/Admin/DashboardController.php)
- Overview stats (Total Services, Pending Approvals).

#### [NEW] [Admin/CategoryController.php](file:///home/ticktick/Desktop/nagorik-sheba/app/Http/Controllers/Admin/CategoryController.php)
- CRUD for Categories (managing the hierarchy).

#### [NEW] [Admin/ServiceController.php](file:///home/ticktick/Desktop/nagorik-sheba/app/Http/Controllers/Admin/ServiceController.php)
- List all services.
- **Approve/Reject** workflow.
- Edit service details including `meta_data`.

## Verification Plan

### Automated Tests
- Run `php artisan test` to verify:
    - Model relationships (Category parent/children).
    - Service creation with `meta_data`.
    - Access control (Admin vs User).

### Manual Verification
1.  **Homepage**: Verify all Super Categories are listed with correct Main Categories.
2.  **Navigation**: Click a Main Category -> See Sub-categories or Listings.
3.  **Listing Detail**: Open a Doctor listing -> Verify "Specialty" and "Chamber" are visible. Open a Car listing -> Verify "Driver Name" is visible.
4.  **Admin**: Log in as Admin -> Approve a pending service -> Verify it appears on the frontend.
