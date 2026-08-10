# Design System Inspired by PlayStation

## 1. Visual Theme & Atmosphere

The PlayStation design system embodies a premium, tech-forward gaming ecosystem that balances sophistication with approachability. The visual language prioritizes clean minimalism paired with vibrant accent moments—bold blues and golds punctuate neutral backgrounds to draw attention to hero content and interactive elements. The aesthetic is contemporary and confident, with generous whitespace that reinforces the high-end nature of gaming hardware and experiences. Typography is refined and light-weighted, creating an air of elegance, while strategic use of deep blacks and whites maintains razor-sharp contrast for accessibility and visual hierarchy. The overall mood is immersive yet navigable, reflecting a brand committed to elevating the player experience.

**Key Characteristics**
- Bold, tech-forward primary blue as the dominant interactive accent
- Refined light typography (weight 300) for headings, establishing premium feel
- Deep neutral blacks and pure whites creating high-contrast clarity
- Subtle golden/amber accents used strategically for secondary actions and highlights
- Minimal border radius conventions—clean edges or highly rounded button treatments
- Generous whitespace and breathing room around content modules
- Subtle drop shadows for depth without visual clutter
- Opacity modulation for layering and focus management

## 2. Color Palette & Roles

### Primary
- **PlayStation Blue** (`#0068BD`): Primary interactive element, call-to-action buttons, links, and brand identity anchor. Used extensively across navigation and primary CTAs.
- **PlayStation Dark Blue** (`#0070CC`): Slightly lighter variant for hover states and secondary prominence on interactive elements.

### Accent Colors
- **Gold** (`#DFBD4D`): Warning and highlight accent for secondary CTAs and alert states.
- **Amber** (`#F6BD23`): Enhanced warning and notification highlight for high-priority secondary actions.
- **Pale Gold** (`#E7CD78`): Softer accent variant for hover and interaction states on secondary elements.
- **Cream Gold** (`#EFDDA3`): Lightest gold variant for background accents and low-priority notifications.

### Interactive
- **Hyperlink Blue** (`#0000EE`): Legacy hyperlink color for text links requiring standard web convention.
- **Error Red** (`#D63D00`): Error states, critical alerts, and destructive actions.
- **Warning Yellow** (`#FEEB37`): High-visibility warning indicator for time-sensitive notifications.

### Neutral Scale
- **Charcoal Black** (`#1F1F1F`): Primary text color, dominant neutral for all body text, labels, and content hierarchy. Most frequently used neutral.
- **Pure White** (`#FFFFFF`): Primary background and text on dark surfaces. Essential for contrast and content clarity.
- **Jet Black** (`#000000`): Maximum contrast black for critical text, borders, and strong visual separation.
- **Dark Gray** (`#363636`): Secondary text, disabled states, and lower-priority content.
- **Medium Gray** (`#CCCCCC`): Light borders, dividers, and subtle background fills.
- **Off-Black** (`#050606`): Near-black for extremely subtle depth and layering.
- **Soft Gray** (`#D1D3DF`): Lightest neutral for very subtle borders and background accents.

### Surface & Borders
- **Page Background** (`#FFFFFF`): Default clean background for primary content areas.
- **Dark Section Background** (`#1F1F1F`): Deep dark background for hero sections, high-contrast content, and visual breaks.
- **Subtle Border** (`#CCCCCC`): Thin dividers and card borders requiring minimal visual weight.

## 3. Typography Rules

### Font Family
**Primary:** SST, sst (custom PlayStation font stack)
**Fallback:** -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif

### Hierarchy

| Role | Font | Size | Weight | Line Height | Letter Spacing | Notes |
|------|------|------|--------|-------------|----------------|-------|
| Display / Hero | sst | 39px | 300 | 48.75px | 0px | Large hero headings, ultra-light for premium feel |
| Heading 1 | sst | 39px | 300 | 48.75px | 0px | Page title, main section heading |
| Heading 2 | sst | 39px | 300 | 48.8px | 0px | Large section headers |
| Heading 3 | sst | 25px | 300 | 31.25px | 0px | Subsection headings |
| Heading 4 | sst | 20px | 300 | 25px | 0px | Card titles, minor headings |
| Body | sst | 16px | 400 | 24px | 0px | Primary body text, product descriptions |
| Body Small | sst | 13.3333px | 400 | 20px | 0px | Secondary text, metadata, captions |
| Button | SST | 13.3333px | 500 | 21px | 0px | CTA text, all button variants |
| List Item | SST | 16px | 500 | normal | 0px | Navigational lists, menu items |
| Input | Arial | 13.3333px | 400 | normal | 0px | Form input text, placeholder text |
| Link | sst | 0px | 400 | normal | 0px | Inline hyperlinks (size inferred from context) |

### Principles
- Light font weights (300, 400) establish a premium, contemporary aesthetic and reduce visual heaviness.
- Consistent line-height ratios (1.25x for body, 1.5x+ for headings) ensure legibility and breathing room.
- Button text uses increased font-weight (500) and bold letter forms for affordance and interaction clarity.
- Small text (13.3333px) reserved for tertiary information, metadata, and form inputs only.
- No letter-spacing adjustments except tracking inherited from font metrics.
- All heading sizes follow a deliberate scale (39px → 25px → 20px) preventing visual dissonance.

## 4. Component Stylings

### Buttons

#### Primary Button
- **Background:** `#0068BD`
- **Text Color:** `#FFFFFF`
- **Font:** SST, 13.3333px, weight 500
- **Padding:** `16px 20px`
- **Line Height:** 21px
- **Border Radius:** `999px`
- **Border:** `2px solid transparent`
- **Box Shadow:** none
- **Hover State:** `#0070CC` background
- **Active State:** `#005AA6` background
- **Disabled State:** Background `#CCCCCC`, text `#363636`, opacity `0.5`

#### Secondary Button (Ghost/Outlined)
- **Background:** `#FFFFFF`
- **Text Color:** `#0068BD`
- **Font:** SST, 13.3333px, weight 500
- **Padding:** `16px 20px`
- **Line Height:** 21px
- **Border Radius:** `999px`
- **Border:** `2px solid #0068BD`
- **Box Shadow:** none
- **Hover State:** Background `#F0F6FF`, border `#0070CC`
- **Active State:** Background `#E0EFFF`, border `#005AA6`

#### Tertiary Button (Text-Only)
- **Background:** transparent
- **Text Color:** `#1F1F1F`
- **Font:** SST, 13.3333px, weight 500
- **Padding:** `0px`
- **Line Height:** 21px
- **Border Radius:** `0px`
- **Border:** none
- **Box Shadow:** none
- **Hover State:** Text color `#0068BD`, underline `1px solid #0068BD`
- **Active State:** Text color `#005AA6`

#### Icon Button
- **Background:** transparent
- **Text Color:** `#1F1F1F`
- **Font:** SST, 13px, weight 500
- **Padding:** `0px 20px 0px 5px`
- **Border Radius:** `0px`
- **Border:** none
- **Box Shadow:** none
- **Width:** 47px–125px (adaptive)
- **Height:** 64px
- **Hover State:** Text color `#0068BD`, slight scale increase

### Cards & Containers

#### Standard Card
- **Background:** `#FFFFFF`
- **Text Color:** `#1F1F1F`
- **Border:** none
- **Border Radius:** `16px`
- **Padding:** `20px`
- **Box Shadow:** `rgba(0, 0, 0, 0.06) 0px 4px 8px 0px`
- **Font:** sst, 16px, weight 400, line-height 24px
- **Hover State:** Box shadow `rgba(0, 0, 0, 0.12) 0px 8px 16px 0px`

#### Pill Card (Compact)
- **Background:** transparent
- **Text Color:** `#FFFFFF`
- **Border:** none
- **Border Radius:** `9999px`
- **Padding:** `2px 2px`
- **Box Shadow:** `rgba(0, 0, 0, 0.06) 0px 4px 8px 0px`
- **Font:** sst, 16px, weight 400
- **Width:** 248px
- **Height:** 49px
- **Hover State:** Slight scale increase (1.02x)

#### Hero Container
- **Background:** Linear gradient overlay `rgba(0, 0, 0, 0.25) to rgba(255, 165, 0, 0.1)` on background image
- **Text Color:** `#FFFFFF`
- **Border:** none
- **Border Radius:** `0px`
- **Padding:** `48px 40px`
- **Box Shadow:** none
- **Width:** Full viewport (1440px reference)
- **Height:** 403.5px (adaptive)

### Inputs & Forms

#### Text Input
- **Background:** `#FFFFFF`
- **Text Color:** `#1F1F1F`
- **Font:** Arial, 13.3333px, weight 400
- **Border:** `1px solid #CCCCCC`
- **Border Radius:** `4px`
- **Padding:** `12px 16px`
- **Line Height:** normal
- **Placeholder Color:** `#363636`, opacity `0.6`
- **Focus State:** Border `2px solid #0068BD`, box-shadow `0px 0px 0px 3px rgba(0, 104, 189, 0.1)`
- **Error State:** Border `2px solid #D63D00`, box-shadow `0px 0px 0px 3px rgba(214, 61, 0, 0.1)`
- **Disabled State:** Background `#F5F5F5`, text color `#CCCCCC`, opacity `0.5`

#### Select Dropdown
- **Background:** `#FFFFFF`
- **Text Color:** `#1F1F1F`
- **Font:** SST, 13.3333px, weight 400
- **Border:** `1px solid #CCCCCC`
- **Border Radius:** `4px`
- **Padding:** `12px 16px 12px 12px`
- **Dropdown Icon Color:** `#0068BD`
- **Focus State:** Border `2px solid #0068BD`
- **Open State:** Border radius bottom `0px`, z-index `30`

#### Checkbox
- **Size:** 18px × 18px
- **Border:** `2px solid #CCCCCC`
- **Background (unchecked):** `#FFFFFF`
- **Background (checked):** `#0068BD`
- **Border Radius:** `3px`
- **Checkmark Color:** `#FFFFFF`
- **Focus State:** Outline `2px solid rgba(0, 104, 189, 0.3)`
- **Disabled State:** Background `#F5F5F5`, border `#CCCCCC`, opacity `0.5`

### Navigation

#### Top Navigation Bar
- **Background:** `#FFFFFF`
- **Text Color:** `#1F1F1F`
- **Font:** SST, 16px, weight 500
- **Height:** 64px
- **Padding:** `0px 40px`
- **Border Bottom:** `1px solid #CCCCCC`
- **Item Spacing:** 32px between nav items
- **Active Item:** Text color `#0068BD`, underline `3px solid #0068BD`
- **Hover Item:** Text color `#0070CC`, subtle background `rgba(0, 104, 189, 0.05)`

#### Navigation Link
- **Text Color:** `#1F1F1F`
- **Font:** SST, 16px, weight 500
- **Padding:** `0px 12px`
- **Border Radius:** `0px`
- **Hover State:** Color `#0068BD`, background `rgba(0, 104, 189, 0.08)`
- **Active State:** Color `#0068BD`, border-bottom `3px solid #0068BD`

#### Dropdown Menu (z-index: 50)
- **Background:** `#FFFFFF`
- **Border:** `1px solid #CCCCCC`
- **Border Radius:** `4px`
- **Padding:** `8px 0px`
- **Box Shadow:** `0px 8px 24px rgba(0, 0, 0, 0.15)`
- **Menu Item Padding:** `12px 20px`
- **Menu Item Hover:** Background `#F5F5F5`
- **Text Color:** `#1F1F1F`
- **Font:** SST, 13.3333px, weight 400

## 5. Layout Principles

### Spacing System

The spacing system is built on an 8px base unit with a structured scale ensuring consistency and rhythm across all layouts.

- **8px:** Minimum padding between adjacent elements, compact form inputs
- **12px:** Button labels, small card padding, internal form spacing
- **16px:** Standard padding for cards, list item margins, input padding
- **20px:** Default container padding, section margins, spacing around focused elements
- **24px:** Heading margins, section breaks, larger spacing for breathing room
- **32px:** Inter-section spacing, major layout breaks
- **40px:** Horizontal page padding, large container gutters
- **48px:** Hero section padding, large vertical breaks between sections
- **60px:** Vertical spacing between major content sections
- **64px:** Gap between grid columns, maximum horizontal spacing
- **80px:** Top/bottom margins for full-width sections, page-level vertical rhythm

### Grid & Container

- **Max Width:** 1440px (reference desktop width)
- **Column Strategy:** 12-column flexible grid with 40px horizontal padding on container edges
- **Gutter Width:** 16px between columns
- **Breakpoint Container:** Full width at tablet and below, fixed max-width at desktop
- **Section Pattern:** Content stacks vertically at mobile with 24px margins; at tablet and above, content flows into grid with 40px padding and 32px section breaks
- **Header Height:** Fixed 64px for top navigation persistence

### Whitespace Philosophy

Whitespace is treated as a first-class design element, not empty space. Generous margins around content modules create visual hierarchy and reduce cognitive load. Each section breathes independently with 48px–80px vertical spacing, preventing content fatigue. Horizontal padding scales with viewport: minimal (16px) on mobile, moderate (24px) on tablet, and expansive (40px) on desktop. This breathing room reinforces the premium nature of the PlayStation brand while improving scannability and focus.

### Border Radius Scale

- **0px:** Navigation elements, hero containers, full-width sections—clean, architectural lines
- **3px:** Form inputs, subtle rounding without softness
- **4px:** Dropdowns, popovers, minimal radius for UI clarity
- **12px:** Secondary cards, moderately rounded for friendly feel
- **16px:** Primary cards, standard container rounding
- **999px:** Button pills, fully rounded interactive elements for maximum affordance

### Border Widths

- **Thin:** `1px` — Dividers between sections, subtle borders on light elements, input focus rings
- **Medium:** `2px` — Button borders, active state indicators, strong visual separators
- **Thick:** `3px` — Active navigation underlines, critical focus indicators, highlight borders

## 6. Depth & Elevation

| Level | Treatment | Use |
|-------|-----------|-----|
| Flat (0) | No shadow, transparent background | Text links, ghost buttons, secondary navigation |
| Raised (1) | `rgba(0, 0, 0, 0.06) 0px 4px 8px 0px` | Standard cards, form containers, default UI elements |
| Elevated (2) | `rgba(0, 0, 0, 0.12) 0px 8px 16px 0px` | Card hover states, floating actions, emphasis elements |
| Floating (3) | `0px 12px 24px rgba(0, 0, 0, 0.15)` | Dropdowns, popovers, overlay surfaces |
| Modal (4) | `0px 16px 40px rgba(0, 0, 0, 0.25)` | Modal windows, full-screen overlays, dialog boxes |

**Shadow Philosophy:**
Shadows are minimal and subtle, emphasizing the clean, minimalist PlayStation aesthetic. Rather than dramatic drop shadows, the system uses soft, diffused shadows that suggest elevation without drawing attention. Shadows scale proportionally with z-index, reinforcing layering. The base shadow (`rgba(0, 0, 0, 0.06)`) is barely perceptible, creating psychological separation without visual clutter. This approach maintains the premium, tech-forward feel while preserving accessibility and visual clarity.

### Opacity Levels

- **8% (`0.08`):** Hover state backgrounds, disabled overlay, very subtle visual feedback
- **25% (`0.25`):** Disabled button text, secondary placeholder text, low-emphasis overlays
- **70% (`0.70`):** Modal backdrop, dark overlay on hero images, strong depth
- **75% (`0.75`):** Disabled interactive elements, semitransparent surfaces, focus states

### Z-index / Layering

- **Base (`1-2`):** Standard content, default card layers
- **Dropdown (`10, 29, 30`):** Form dropdowns, expanded menu items, nested popovers
- **Sticky (`50`):** Fixed header, persistent navigation, floating action buttons
- **Modal (`70, 80`):** Modal dialogs, full-screen overlays, highest-priority UI elements

## 7. Do's and Don'ts

### Do
- **Use the PlayStation Blue (`#0068BD`) exclusively for primary CTAs** — it is the trust signal and brand anchor across all interactive elements.
- **Pair light headings (weight 300) with regular body text (weight 400)** to establish clear hierarchy and maintain readability.
- **Apply the subtle shadow (`rgba(0, 0, 0, 0.06) 0px 4px 8px 0px`) to all raised cards** for consistent depth without visual heaviness.
- **Space major sections with 48px–80px vertical margins** to create breathing room and reduce cognitive load.
- **Use pill-shaped buttons (`border-radius: 999px`) for primary actions** and rectangular inputs for secondary interactions.
- **Maintain 1.25x+ line-height ratio on all text** to ensure comfort in reading long-form content.
- **Respect the 8px spacing grid** for all margins, padding, and gaps—consistency builds visual harmony.
- **Use the gold accents (`#DFBD4D`, `#F6BD23`) strategically for secondary CTAs and highlights** only, not for primary content.
- **Test all interactive elements at touch sizes (minimum 48px × 48px)** to ensure mobile usability.
- **Layer dropdowns and modals with appropriate z-index values** (10-30 for dropdowns, 70-80 for modals) to prevent stacking conflicts.

### Don't
- **Avoid using red (`#D63D00`) for anything other than errors or critical alerts** — overuse diminishes its warning power.
- **Never mix font families within a single typographic hierarchy** — commit to SST for consistency, except in inputs (Arial).
- **Don't apply heavy shadows (`0px 12px 24px` or larger) to routine UI elements** — reserve elevation for critical surfaces only.
- **Avoid padding less than 12px on interactive elements** — insufficient padding compromises both touch targets and visual breathing room.
- **Never use text smaller than 13.3333px on body content** — this compromises accessibility and readability, especially on mobile.
- **Don't center-align body text** — left alignment improves scannability and reading speed.
- **Avoid nesting dropdowns more than two levels deep** — excessive nesting creates cognitive load and navigation complexity.
- **Never disable buttons without providing alternative pathways** — always communicate why an action is unavailable.
- **Don't apply opacity below 25% for interactive elements** — reduced opacity below this threshold obscures interactive intent.
- **Avoid sharp 0px border-radius on rounded elements like cards** — apply minimum 12px for consistency with brand softness.

## 8. Responsive Behavior

### Breakpoints

| Name | Width | Key Changes |
|------|-------|-------------|
| Mobile | 320px–479px | Full-width layout, 16px horizontal padding, 24px section spacing, single-column grid, 48px button height, oversized touch targets (56px+) |
| Tablet | 480px–1023px | 24px horizontal padding, 32px section spacing, 2-3 column grid, adaptive card sizing, 24px–32px heading sizes |
| Desktop | 1024px+ | 40px horizontal padding, max-width 1440px container, 12-column grid, full 39px heading sizes, 64px section spacing |
| Ultra-Wide | 1800px+ | Maintain 1440px max-width centered, increase side padding proportionally, wider card grids (4+ columns) |

### Touch Targets

- **Minimum Interactive Size:** 48px × 48px for buttons, links, and tap zones
- **Recommended Interactive Size:** 56px × 56px for primary actions on mobile
- **Spacing Between Targets:** Minimum 8px (12px preferred) to prevent accidental adjacent taps
- **Link Padding:** Minimum 12px around text links to expand tap area without expanding visual bounds
- **Form Input Height:** Minimum 48px on mobile, 44px on desktop for comfortable interaction

### Collapsing Strategy

- **Hero Sections:** Full 403.5px height on desktop → 280px on tablet → 160px on mobile; padding scales from 48px to 24px
- **Navigation:** Horizontal 64px fixed bar on desktop → Hamburger icon with slide-out drawer on mobile (z-index 80)
- **Grid Layout:** 12 columns on desktop → 6 columns on tablet → 1 column stacked on mobile
- **Card Width:** Fluid 100% on mobile → 50% on tablet (2 columns) → `calc(33.33% - 16px)` on desktop (3 columns)
- **Heading Sizes:** 39px desktop → 28px tablet → 24px mobile; line-height scales proportionally
- **Spacing Ratios:** 80px desktop section gaps → 48px tablet → 24px mobile; maintain 1:0.6:0.3 ratio
- **Button Width:** Full width on mobile (100%) → Inline on tablet/desktop (auto)
- **Dropdown Position:** Anchored to bottom on desktop, full-width below trigger on mobile

## 9. Agent Prompt Guide

### Quick Color Reference

- **Primary CTA:** PlayStation Blue (`#0068BD`)
- **Secondary CTA:** White with blue border (`#FFFFFF` bg, `#0068BD` border)
- **Text (Dark):** Charcoal Black (`#1F1F1F`)
- **Text (Light):** Pure White (`#FFFFFF`)
- **Background (Light):** Pure White (`#FFFFFF`)
- **Background (Dark):** Charcoal Black (`#1F1F1F`)
- **Accent/Highlight:** Gold (`#DFBD4D`), Amber (`#F6BD23`)
- **Borders/Dividers:** Medium Gray (`#CCCCCC`)
- **Error State:** Error Red (`#D63D00`)
- **Warning State:** Warning Yellow (`#FEEB37`)
- **Link Text:** Hyperlink Blue (`#0000EE`)

### Iteration Guide

1. **Primary Blue is law:** Every interactive element (button, link, focus state) that signals primary action must use `#0068BD`. Secondary actions and hover states shift to `#0070CC`. Maintain this hierarchy rigorously.

2. **Light typography establishes premium feel:** All headings default to weight 300 (light); body text is weight 400 (regular); interactive text and buttons are weight 500 (semibold). Never deviate from these weights—they define the brand's refined aesthetic.

3. **8px grid is non-negotiable:** All spacing (margins, padding, gaps) must be multiples of 8px. This ensures visual rhythm and simplifies responsive calculations. Reference the spacing scale: 8, 12, 16, 20, 24, 32, 40, 48, 60, 64, 80.

4. **Shadows are subtle, never dramatic:** Default card shadow is always `rgba(0, 0, 0, 0.06) 0px 4px 8px 0px`. Hover states increment to `rgba(0, 0, 0, 0.12) 0px 8px 16px 0px`. Never apply heavier shadows to routine elements—reserve those for modals and critical overlays only.

5. **Button styling is polarized:** Primary buttons are fully rounded pills (`border-radius: 999px`) with blue background and white text. Secondary buttons are outlined (2px border, white background, blue text). Tertiary buttons are text-only with no background. Icon buttons are borderless and transparent. There is no middle ground.

6. **Form inputs use tight, crisp styling:** All inputs are 4px border-radius with 1px borders, 12px vertical padding, and 16px horizontal padding. Focus states add a 2px blue border and 3px colored box-shadow for accessibility. Never apply rounded corners greater than 4px on form elements.

7. **Navigation is persistent and minimal:** Top nav is always 64px fixed height with 40px horizontal padding, using weight 500 text. Active states use bottom borders (3px solid `#0068BD`), not background fills. Hover states are subtle background fills only (`rgba(0, 104, 189, 0.05)`).

8. **Mobile breakpoint triggers layout collapse:** At 480px and below, switch to single-column grids, full-width buttons, 16px padding, and oversized touch targets (56px+). Navigation collapses to hamburger menu with 80px z-index drawer overlay.

9. **Z-index is strictly layered:** Base content stays 1–2. Dropdowns live at 10–50. Modals and overlays occupy 70–80. Never use arbitrary z-index values; consult the stacking scale to prevent conflicts.

10. **Container max-width is 1440px:** On desktop, constrain layouts to 1440px max-width and center horizontally. On mobile/tablet, use full-width with proportional horizontal padding (16px, 24px, 40px respectively). Never let content extend beyond 1440px even on ultra-wide displays.