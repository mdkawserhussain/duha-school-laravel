You will create a comprehensive, production-ready Cursor AI rules file for the **Duha International School** project.

There are already   cursor rule files at @./plan/rulesbygemini.txt   . take them as reference and generate an updated, enhanced and optimized cursor rules file according to the instructions below- 

Before writing the rules, thoroughly analyze **the entire project codebase, history, @plan folder, and current state** as of November 17, 2025. This includes:

- All past conversations and decisions from the "Al-Maghrib → Duha" rename until today
- Every fix, feature, and architectural decision (transparent glassy navbar, hero touching top, WebP + original-delete pipeline, background-removal logo, Hero Slider Manager page, collapsible Homepage Settings sidebar, cache keys, Filament Section + columns(), etc.)
- The final visual design system (navbar layout, brand section with red line, hero overlapping navbar, scroll-triggered fade-ins, mobile behavior)
- All technical constraints and non-negotiables (no Grid::make, singleFile() collections, cache clearing in afterSave/afterDelete, Alpine.js only, etc.)
- The strict context-switching rule: only switch when user explicitly says **[different project]**

Once analysis is complete, generate a **ready-to-paste Markdown rules file** (for Cursor → Settings → Rules for AI or .cursor/rules.md) that **permanently locks Cursor** into this exact project state.

Write the rules in strict, absolute language using **MUST**, **NEVER**, **ALWAYS**, **ONLY**, and **MUST NOT** to eliminate any possibility of deviation.

Structure the rules with clear sections:

- Project Identity & Naming
- Tech Stack & Versions
- Color Palette
- Media & Image Pipeline (WebP + delete original + background removal)
- Caching Strategy & Keys
- Navbar (exact layout + transparent → solid behavior)
- Hero Section (zero gap + overlap)
- Homepage Sections & Animations
- Filament Admin Panel (sidebar structure, Hero Slider Manager, Site Settings)
- Frontend Standards (picture tag, Alpine.js only, mobile-first)
- Context Switching Rule
- Forbidden Patterns (Grid::make, external libraries, wrong school name, etc.)

Your output MUST be structured exactly in the following sections:

---

# **1. PROJECT OVERVIEW & GOALS**

- High-level overview
- Project purpose
- Goals & success criteria

---

# **2. PROJECT SUMMARY**

Concise summary describing what the system does and how it works.

---

# **3. FEATURES LIST**

Break into:

```
Core Features
Admin Panel (Filament)
Advanced Features
Dynamic Manageable Features
```

---

# **4. TECHNICAL ARCHITECTURE**

- System architecture diagram (text-based)
- Backend architecture
- Frontend architecture
- Deployment architecture
- Request lifecycle flow

---

# **5. RECOMMENDED TECH STACK**

- Backend (Laravel version, PHP extensions)
- Frontend (Blade/Tailwind, Livewire/Vue optional)
- Admin panel (Filament v3)
- Database (MySQL)
- Tools, libraries, packages
- DevOps tools

---

# **6. PROJECT STRUCTURE**

Explain:

- Folder structure
- Modular separation
- Domain-driven grouping
- Naming conventions

---

# **7. DATABASE DESIGN**

Provide:

- ERD (text-based diagram)
- Tables list
- Fields with types
- Relationships
- Constraints
- Normalization rules
- Index strategy

---

# **8. DATA MODEL (Eloquent Models & Key Fields)**

List all models with:

- Fields
- Casts
- Relationships
- Scopes (if needed)

---

# **9. MIGRATIONS**

List migrations required for all tables.

Include:
- Schema fields
- Foreign keys
- Soft deletes/journaling

---

# **10. ROUTES**

Provide:

- API routes
- Web routes
- Admin routes
- Auth routes

(in full structured list)

---

# **11. CONTROLLERS — RESPONSIBILITIES**

For each controller:

- Purpose
- Methods
- Validation rules (FormRequest)
- Input/output structure

---

# **12. CODING PATTERNS**

Explain:

- Controller → Service → Repository pattern
- FormRequest validation
- DTO usage (if needed)
- Caching strategy
- Queues/jobs
- Policy/Permission structure

---

# **13. ADMIN UI (FILAMENT SETUP)**

Detail:

- Panels
- Resources
- Pages
- Widgets
- Tables
- Forms
- Filters
- Media upload logic

---

# **14. UI/UX DESIGN PLAN**

Include:

- Design system
- Components
- Color/style guidelines
- Page layouts
- Mobile responsiveness

---

# **15. PUBLIC SITE STRUCTURE**

List:

- All pages
- All URLs
- Menu structure
- User flows

---

# **16. SRS — FUNCTIONAL & NON-FUNCTIONAL REQUIREMENTS**

Include:

- Functional requirements
- Non-functional (performance, security, scalability)
- Constraints
- Optimization techniques

---

# **17. BUSINESS LOGIC**

Explain all business workflows:

- User workflows
- Admin workflows
- Automations
- Conditional logic

---

# **18. USE CASES**

List clear use case descriptions with:

- Actors
- Preconditions
- Flow
- Success result

---

# **19. AUTHENTICATION & ROLES**

Define:

- User types
- Role permissions
- Middleware
- Access control matrix

---

# **20. NOTIFICATIONS & EMAIL**

Detail:

- Events
- Notification types
- Email templates
- SMS/Push (optional)

---

# **21. MEDIA & FILE HANDLING**

Explain:

- Storage strategy
- File naming
- Image optimization
- Media library usage

---

# **22. SEO, SCHEMA & PERFORMANCE**

Include:

- Meta tags
- JSON-LD structure
- Sitemap
- Cache strategy
- Query optimization

---

# **23. TESTING & QA**

Include:

- Manual testing checklist
- Automated test cases
- API tests
- Browser tests

---

# **24. DEVELOPMENT PHASES**

Break down:

- Phase 1 — Architecture
- Phase 2 — Database
- Phase 3 — Backend APIs
- Phase 4 — Admin Panel
- Phase 5 — UI/UX front-end
- Phase 6 — Integrations
- Phase 7 — Testing
- Phase 8 — Deployment

---

# **25. MILESTONES & TIMELINE**

Include:

- Deliverables
- Estimated time
- Dependencies

---

# **26. DEPLOYMENT CHECKLIST**

Include:

- Server setup
- Env configuration
- Cron jobs
- Queue workers
- Database backup

---

# **27. REQUIRED PACKAGES**

List all composer/npm packages.

---

# **28. TOOLS & COMMANDS CHEAT SHEET**

Include:

- Composer commands
- NPM commands
- Artisan commands
- Filament commands

---

# **29. FUTURE ENHANCEMENTS**

Suggest features to scale later.

---

# **30. SECURITY, USABILITY, SCALABILITY & MAINTAINABILITY**

Provide in-depth considerations and recommendations.

---

## List all source files and folders in the project and include in your cursor rule outlining the directory structure and important files and folders. Analyze all major dependencies and include in your cursor rule outlining the stack of the application and the versions I'm using, and any remarks on best practices for those versions.

## **The following rules should be included in the beginning:**

- Top of rules. Important: call me (Kawser) at the start of every conversation.
- Important: fix things at the cause, not the symptom.
- Be very detailed with summarization and do not miss important things.
- Don't be helpful, be better.
- Write better code.
- Check the README and update it often.
- When a fault, error, failure, or unexpected output is experienced:
    - Attempt a maximum of one fix at a time
    - Validate if that fix resolved the issue
    - If the fix failed, undo it and reset the fix counter
    - Reevaluate the issue using detailed line-by-line analysis
    - Continue iterating until the issue is resolved

---

## description: How to add or edit Cursor rules in our project
globs:
alwaysApply: false

# Cursor Rules Location

How to add new cursor rules to the project

1. Always place rule files in PROJECT_ROOT/.cursor/rules/:

    ```
    .cursor/rules/
    ├── your-rule-name.mdc
    ├── another-rule.mdc
    └── ...
    ```

2. Follow the naming convention:
    - Use kebab-case for filenames
    - Always use .mdc extension
    - Make names descriptive of the rule's purpose
3. Directory structure:

    ```
    PROJECT_ROOT/
    ├── .cursor/
    │   └── rules/
    │       ├── your-rule-name.mdc
    │       └── ...
    └── ...
    ```

4. Never place rule files:
    - In the project root
    - In subdirectories outside .cursor/rules
    - In any other location
5. Cursor rules have the following structure:

```
---
description: Short description of the rule's purpose
globs: optional/path/pattern/**/*
alwaysApply: false
---
# Rule Title

Main content explaining the rule with markdown formatting.

1. Step-by-step instructions
2. Code examples
3. Guidelines

Example:

```typescript
// Good example
function goodExample() {
  // Implementation following guidelines
}

// Bad example
function badExample() {
  // Implementation not following guidelines
}
```

---

## description: Guidelines for continuously improving Cursor rules based on emerging code patterns and best practices.
globs: ***/
alwaysApply: true

## Rule Improvement Triggers

- New code patterns not covered by existing rules
- Repeated similar implementations across files
- Common error patterns that could be prevented
- New libraries or tools being used consistently
- Emerging best practices in the codebase

# Analysis Process:

- Compare new code with existing rules
- Identify patterns that should be standardized
- Look for references to external documentation
- Check for consistent error handling patterns
- Monitor test patterns and coverage

# Rule Updates:

- **Add New Rules When:**
    - A new technology/pattern is used in 3+ files
    - Common bugs could be prevented by a rule
    - Code reviews repeatedly mention the same feedback
    - New security or performance patterns emerge
- **Modify Existing Rules When:**
    - Better examples exist in the codebase
    - Additional edge cases are discovered
    - Related rules have been updated
    - Implementation details have changed
- **Example Pattern Recognition:**

    ```tsx
    // If you see repeated patterns like:
    const data = await prisma.user.findMany({
      select: { id: true, email: true },
      where: { status: 'ACTIVE' }
    });

    // Consider adding to [prisma.mdc](mdc:shipixen/.cursor/rules/prisma.mdc):
    // - Standard select fields
    // - Common where conditions
    // - Performance optimization patterns
    ```

- **Rule Quality Checks:**
- Rules should be actionable and specific
- Examples should come from actual code
- References should be up to date
- Patterns should be consistently enforced

## Continuous Improvement:

- Monitor code review comments
- Track common development questions
- Update rules after major refactors
- Add links to relevant documentation
- Cross-reference related rules

## Rule Deprecation

- Mark outdated patterns as deprecated
- Remove rules that no longer apply
- Update references to deprecated rules
- Document migration paths for old patterns

## Documentation Updates:

- Keep examples synchronized with code
- Update references to external docs
- Maintain links between related rules
- Document breaking changes

Follow [cursor-rules.mdc](mdc:.cursor/rules/cursor-rules.mdc) for proper rule formatting and structure.

## **OUTPUT FORMAT**

- Use **headings**, **tables**, **diagrams**, **lists**, and **code blocks**.
- Make everything detailed, actionable, and production-ready.

Output only the final, complete Markdown rules file in .cursor/rules/cursor-rules.mdc — nothing else. Make it so comprehensive that Cursor will never generate code that doesn't perfectly match the current production state of Duha International School.

## Enhancements to the Prompt:

- Ensure the rules file includes a section for **Error Handling & Debugging Protocols** based on the specified fault-handling rules.
- Add a section for **Code Review Guidelines** to enforce the "fix at the cause" and "write better code" principles.
- Incorporate real-time analysis of the codebase to include specific examples from the Duha project (e.g., reference actual files like HeroSliderManager.php or navbar.blade.php).
- Expand the **Forbidden Patterns** section with more examples from past decisions, such as avoiding certain Filament methods or ensuring Alpine.js exclusivity.
- Include a **Version Control & Git Workflow** section to maintain consistency with project history.
- Add **Accessibility & Internationalization** considerations, as it's an international school.
- Enhance the **Testing & QA** section with specific test cases for Duha's features, like hero slider animations or cache invalidation.
- Require the rules to include **Performance Benchmarks** for key features, ensuring they meet non-functional requirements.
- Add a **Change Log** section in the rules file to track updates to the rules themselves, referencing the improvement guidelines.
- Make the language even stricter, using phrases like "Under no circumstances" or "It is imperative that" to reinforce absolutes.
- Include a **Glossary of Terms** at the end for project-specific jargon (e.g., "Hero Slider Manager", "Glassy Navbar").
- Ensure the output filename is specified as .cursor/rules/duha-international-school-rules.mdc for clarity and specificity.


I am attaching a plan below that you can use to generate the output

Enhanced Cursor Rules Generation Plan
Analysis Complete
✅ Reviewed existing rules files (rulesbygemini.mdc, dis-international-school-rules.mdc)
✅ Analyzed codebase structure and key implementations
✅ Identified project-specific patterns (navbar, hero, WebP pipeline, cache keys)
✅ Documented forbidden patterns (Grid::make, external JS frameworks)
✅ Captured design system (colors, typography, spacing)
✅ Reviewed Filament resources structure and patterns
Implementation Steps
1. Create Enhanced Rules File Structure
File: .cursor/rules/duha-school-rules.mdc

Sections to Include (30 sections as specified):

Project Overview & Goals
Project Summary
Features List (Core, Admin, Advanced, Dynamic Manageable)
Technical Architecture
Recommended Tech Stack (with exact versions from composer.json/package.json)
Project Structure (with actual directory listing)
Database Design
Data Model (Eloquent Models & Key Fields)
Migrations
Routes
Controllers — Responsibilities
Coding Patterns
Admin UI (Filament Setup)
UI/UX Design Plan
Public Site Structure
SRS — Functional & Non-Functional Requirements
Business Logic
Use Cases
Authentication & Roles
Notifications & Email
Media & File Handling
SEO, Schema & Performance
Testing & QA
Development Phases
Milestones & Timeline
Deployment Checklist
Required Packages (from composer.json/package.json)
Tools & Commands Cheat Sheet
Future Enhancements
Security, Usability, Scalability & Maintainability
2. Key Enhancements to Include
Project Identity & Naming
MUST use "Duha International School" (never "Al-Maghrib" or "AISD")
MUST reference the rename from Al-Maghrib → Duha
MUST call user "Kawser" at start of every conversation
Navbar Implementation
MUST be transparent on homepage hero, solid white on scroll
MUST use Alpine.js for scroll detection (x-data="navbarComponent")
MUST have zero gap between announcement bar, navbar, and hero
MUST overlay hero section (hero starts at absolute top)
MUST use classes: navbar-transparent → navbar-scrolled
Hero Section
MUST start at absolute top with zero margin/padding
MUST overlap navbar (navbar is fixed, hero content has z-10)
MUST support video backgrounds with poster images
MUST use HeroSliderManager Filament page for management
MUST clear homepage_v2_data cache on changes
Media & Image Pipeline
MUST convert all images to WebP format
MUST delete original image after WebP conversion (via MediaObserver)
MUST use singleFile() for logo, favicon, featured images
MUST use Spatie Media Library for all uploads
MUST generate responsive sizes (thumb, medium, large)
MUST support background removal for logo (if implemented)
Caching Strategy
MUST use cache keys: homepage_v2_data, events_index_{hash}, notices_index_{hash}
MUST clear cache in observers (afterSave, afterDelete)
MUST use Redis for production, database/file fallback for dev
MUST set HTTP cache headers (Cache-Control: public, max-age=3600)
Filament Admin Patterns
MUST use Components\Section::make()->schema([...])->columns(2) (NOT Grid::make())
MUST use SpatieMediaLibraryFileUpload for media
MUST clear homepage cache in afterSave/afterDelete hooks
MUST use HeroSliderManager page for hero slides
MUST use collapsible sidebar for Homepage Settings
MUST implement role-based access (admin, editor, admissions_officer)
Frontend Standards
MUST use Alpine.js ONLY (no Vue, React, or other frameworks)
MUST use <picture> tag for responsive images with WebP fallback
MUST be mobile-first responsive
MUST use Tailwind CSS 4.0 (no Bootstrap or other CSS frameworks)
MUST implement scroll-triggered fade-in animations
MUST use semantic HTML5 elements
Color Palette
Primary: Brand blues (#6366f1, #4f46e5, #4338ca)
Accent: Gold (#FCD34D, #F4C430)
Neutral: Ink grays (#1E293B, #475569)
MUST use CSS variables for consistency
Forbidden Patterns
MUST NOT use Grid::make() in Filament forms (use Section::make()->columns())
MUST NOT introduce Vue, React, or other JS frameworks
MUST NOT use "Al-Maghrib" or "AISD" in new code
MUST NOT use inline styles (use Tailwind classes)
MUST NOT hardcode values (use config/env variables)
MUST NOT put business logic in controllers or models
MUST NOT use raw SQL queries
Context Switching Rule
MUST remain focused on Duha International School project
ONLY switch projects when user explicitly states [different project]
3. Additional Sections to Add
Error Handling & Debugging Protocols
Single fix at a time protocol
Validation before next fix
Undo and re-evaluate on failure
Detailed line-by-line analysis
Code Review Guidelines
Fix at root cause, not symptoms
Write better, more efficient code
Check and update README often
Version Control & Git Workflow
Feature branches
Descriptive commit messages
Pull request reviews
Tags for releases
Performance Benchmarks
Page load < 2 seconds
Handle 1000 concurrent users
Core Web Vitals monitoring
Image optimization targets
Glossary of Terms
Hero Slider Manager
Glassy Navbar
WebP Pipeline
Cache Keys
SingleFile Collections
4. File Structure to Document
Include actual directory structure from analysis:

app/ structure (Controllers, Services, Repositories, Filament)
resources/views structure
database/ structure
All key files and their purposes
5. Dependencies to Document
From composer.json and package.json:

Exact versions of all packages
Purpose of each package
Best practices for each version
6. Output Format
Markdown with proper headings
Tables for structured data
Code blocks for examples
Strict language (MUST, NEVER, ALWAYS, ONLY)
Actionable and production-ready
Deliverables
Complete .cursor/rules/duha-international-school-rules.mdc file
All 30 required sections
Project-specific patterns documented
Forbidden patterns clearly stated
Real examples from codebase
Version numbers from actual dependencies
Directory structure from actual project
---


