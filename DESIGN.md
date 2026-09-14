---
name: Civic Pulse
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#45474c'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#75777d'
  outline-variant: '#c5c6cd'
  surface-tint: '#545f73'
  primary: '#091426'
  on-primary: '#ffffff'
  primary-container: '#1e293b'
  on-primary-container: '#8590a6'
  inverse-primary: '#bcc7de'
  secondary: '#0051d5'
  on-secondary: '#ffffff'
  secondary-container: '#316bf3'
  on-secondary-container: '#fefcff'
  tertiary: '#00190e'
  on-tertiary: '#ffffff'
  tertiary-container: '#00301e'
  on-tertiary-container: '#00a472'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d8e3fb'
  primary-fixed-dim: '#bcc7de'
  on-primary-fixed: '#111c2d'
  on-primary-fixed-variant: '#3c475a'
  secondary-fixed: '#dbe1ff'
  secondary-fixed-dim: '#b4c5ff'
  on-secondary-fixed: '#00174b'
  on-secondary-fixed-variant: '#003ea8'
  tertiary-fixed: '#6ffbbe'
  tertiary-fixed-dim: '#4edea3'
  on-tertiary-fixed: '#002113'
  on-tertiary-fixed-variant: '#005236'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display:
    fontFamily: Inter
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  title-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.05em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 0.5rem
  sm: 1rem
  md: 1.5rem
  lg: 2rem
  xl: 3rem
  container-max: 1280px
  gutter: 1.5rem
---

## Brand & Style

The design system is anchored in a **Corporate/Modern** aesthetic, specifically tailored for the civic-tech sector. It prioritizes clarity, accessibility, and a sense of institutional reliability. The brand personality is professional and trustworthy, designed to bridge the communication gap between students and school administration.

The visual style utilizes a "Clean & Systematic" approach:
- **High Information Density:** Layouts are organized to handle complex data (complaint logs, status tracking) without overwhelming the user.
- **Trust-Oriented:** Avoids trendy flourishes in favor of stable, geometric structures and a high-contrast color palette that ensures legibility for all users.
- **Action-Focused:** Primary interactive elements are clearly distinguished to minimize cognitive load during the reporting process.

## Colors

The color palette is built on a foundation of "Light Slate" to maintain a clean, airy feel that reduces the "bureaucratic" weight of a complaint system.

- **Primary (#1E293B):** Used for navigation backgrounds, high-level headers, and text to establish authority.
- **Interactive (#2563EB):** Reserved for primary buttons, active states, and links to guide user progression.
- **Semantic Accents:** 
    - **Emerald Green (#10B981):** Indicators for "Resolved" or "Completed" status.
    - **Amber (#F59E0B):** Indicators for "Pending" or "In-Progress" status.
    - **Soft Red (#EF4444):** Errors, urgent alerts, or "Declined" feedback.
- **Neutrals:** A scale of Slates (50–900) provides hierarchy for borders, secondary text, and icons.

## Typography

The design system utilizes **Inter** for its exceptional legibility and neutral, professional tone. 

- **Hierarchy:** Use `display` only for dashboard hero stats or empty state titles. `headline-md` is the standard for card titles and section headers.
- **Readability:** Body text uses a generous line height (1.5x) to ensure that long descriptions of facility issues remain easy to scan.
- **Labels:** `label-md` should be used for status badges and input field labels, often set in Medium (500) weight to distinguish them from standard body text.

## Layout & Spacing

This design system employs a **Fluid Grid** with a maximum container width of 1280px for desktop views.

- **Grid Model:** 12-column system for desktop, 6-column for tablet, and 4-column for mobile.
- **Rhythm:** An 8px/4px base unit (soft grid) governs all margins and padding. 
- **Dashboards:** Use a fixed sidebar (280px) for Admin layouts and a top-navigation/bottom-bar hybrid for the student mobile experience.
- **Margins:** Standard page margins are `lg` (32px) on desktop and `sm` (16px) on mobile to maximize content real estate on smaller devices.

## Elevation & Depth

Visual hierarchy is managed through **Tonal Layers** and subtle **Ambient Shadows**.

- **Surface Levels:** The primary background is `Light Slate (#F8FAFC)`. All primary content cards sit on `White (#FFFFFF)` to create immediate separation.
- **Shadows:** Use extremely diffused shadows for cards (Blur: 15px, Y: 4px, Color: 4% #1E293B). This creates a sense of "resting" on the surface rather than floating high above it.
- **Interactive Depth:** Buttons use a solid flat fill. On hover, they should darken slightly (5-10%) rather than increasing shadow depth, maintaining the modern professional aesthetic.
- **Outlines:** Use `Slate-200` for input borders and card dividers to provide structure without adding visual noise.

## Shapes

The shape language is consistently "Rounded" to soften the institutional nature of the application and make it feel approachable for students.

- **Cards:** Use `rounded-xl` (1.5rem / 24px) to define major content areas.
- **Buttons & Inputs:** Use `rounded-lg` (1rem / 16px) to provide a comfortable touch target and modern look.
- **Status Pills:** Use `rounded-full` (999px) for status indicators (e.g., "In Progress") to clearly distinguish them from actionable buttons.

## Components

### Buttons
- **Primary:** Royal Blue background, white text, `rounded-lg`.
- **Secondary:** Transparent background, Royal Blue border (1px), `rounded-lg`.
- **Ghost:** No border, Slate-600 text, for low-priority actions like "Cancel."

### Status Badges (Pills)
- Status indicators must use a **Soft Background Tint** (10-15% opacity of the semantic color) with high-contrast text of the same hue.
- *Example:* "Resolved" uses Emerald Green text on a very light green background.

### Input Fields
- **Default:** `Slate-200` border, `White` background, `rounded-lg`.
- **Focus State:** `Royal Blue` 2px border with a soft blue glow (3px spread).
- **Icons:** Use 20px icons (Slate-400) for search, password toggles, and date pickers.

### Cards
- Always `White` background with `rounded-xl` corners and the standard ambient shadow.
- Inner padding should be `md` (24px) to ensure content breathe.

### Feedback Timeline
- A vertical stepper component for the Admin view to show the history of a complaint (Submitted -> Verified -> Fixed). Use thin `Slate-200` lines and colored dots matching status colors.