---
version: alpha
name: UCSF Clinical Academic
description: A restrained academic health system with deep navy authority, bright blue accents, and editorial typography.
colors:
  primary: "#006BE9"
  secondary: "#052049"
  tertiary: "#F2F3F4"
  neutral: "#FFFFFF"
  surface: "#F2F3F4"
  on-surface: "#052049"
  border: "#E5E7EB"
  muted: "#6B7280"
  error: "#D92D20"
typography:
  headline-display:
    fontFamily: GranjonLTW01-Roman
    fontSize: 82px
    fontWeight: 500
    lineHeight: 82px
    letterSpacing: -2px
  headline-lg:
    fontFamily: GranjonLTW01-Roman
    fontSize: 56px
    fontWeight: 500
    lineHeight: 70px
    letterSpacing: -1.2px
  headline-md:
    fontFamily: HelveticaNeueLTW04-45Light
    fontSize: 38px
    fontWeight: 500
    lineHeight: 46px
    letterSpacing: 0.2px
  headline-sm:
    fontFamily: HelveticaNeueLTW04-45Light
    fontSize: 26px
    fontWeight: 500
    lineHeight: 31px
    letterSpacing: 0px
  body-lg:
    fontFamily: HelveticaNeueLTW04-45Light
    fontSize: 18px
    fontWeight: 500
    lineHeight: 32px
    letterSpacing: 0.2px
  body-md:
    fontFamily: HelveticaNeueLTW04-45Light
    fontSize: 16px
    fontWeight: 500
    lineHeight: 28px
    letterSpacing: 0.2px
  body-sm:
    fontFamily: HelveticaNeueLTW04-45Light
    fontSize: 14px
    fontWeight: 500
    lineHeight: 22px
    letterSpacing: 0.2px
  label-lg:
    fontFamily: HelveticaNeueLTW04-65Medium
    fontSize: 18px
    fontWeight: 500
    lineHeight: 24px
    letterSpacing: 0px
  label-md:
    fontFamily: HelveticaNeueLTW04-65Medium
    fontSize: 16px
    fontWeight: 500
    lineHeight: 20px
    letterSpacing: 0px
  label-sm:
    fontFamily: HelveticaNeueLTW04-65Medium
    fontSize: 12px
    fontWeight: 500
    lineHeight: 16px
    letterSpacing: 0.08em
  nav:
    fontFamily: HelveticaNeueLTW04-45Light
    fontSize: 18px
    fontWeight: 500
    lineHeight: 24px
    letterSpacing: 0px
  caption:
    fontFamily: HelveticaNeueLTW04-65Medium
    fontSize: 13px
    fontWeight: 500
    lineHeight: 16px
    letterSpacing: 0.12em
rounded:
  none: 0px
  sm: 4px
  md: 8px
  lg: 16px
  xl: 32px
  full: 9999px
spacing:
  xs: 8px
  sm: 18px
  md: 26px
  lg: 40px
  xl: 60px
  gutter: 24px
  margin: 32px
components:
  button-primary:
    backgroundColor: "transparent"
    textColor: "{colors.primary}"
    typography: "{typography.label-lg}"
    rounded: "{rounded.full}"
    padding: "0px 24px"
    height: "64px"
  button-primary-hover:
    backgroundColor: "transparent"
    textColor: "{colors.secondary}"
    typography: "{typography.label-lg}"
    rounded: "{rounded.full}"
    padding: "0px 24px"
    height: "64px"
  button-secondary:
    backgroundColor: "transparent"
    textColor: "{colors.primary}"
    typography: "{typography.label-lg}"
    rounded: "{rounded.full}"
    padding: "0px 24px"
    height: "64px"
  button-tertiary:
    backgroundColor: "transparent"
    textColor: "{colors.primary}"
    typography: "{typography.label-md}"
    rounded: "{rounded.none}"
    padding: "0px"
    height: "auto"
  card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.sm}"
    padding: "16px"
  input:
    backgroundColor: "{colors.neutral}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.sm}"
    padding: "12px 16px"
    height: "48px"
  chip:
    backgroundColor: "{colors.neutral}"
    textColor: "{colors.primary}"
    typography: "{typography.label-sm}"
    rounded: "{rounded.full}"
    padding: "6px 12px"
  topbar:
    backgroundColor: "{colors.secondary}"
    textColor: "{colors.neutral}"
    typography: "{typography.label-sm}"
    height: "42px"
  nav-link:
    backgroundColor: "transparent"
    textColor: "{colors.on-surface}"
    typography: "{typography.nav}"
    padding: "0px"
  hero-panel:
    backgroundColor: "{colors.neutral}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.none}"
    padding: "0px"
---

# UCSF Clinical Academic

## Overview
This system feels authoritative, calm, and institutionally credible, with a strong academic-medical voice. It balances an editorial, almost luxury-style serif headline treatment with clean sans-serif navigation and utility text, creating a polished but not overly ornate experience. The overall layout is spacious and image-led, aimed at a broad public audience that needs clarity, trust, and a sense of prestige.

## Colors
- **Primary (#006BE9):** A vivid UCSF blue used for calls to action, links, and interactive emphasis. It should feel energetic and trustworthy rather than decorative.
- **Secondary (#052049):** A deep navy used for the brand wordmark, major headlines, and the strongest text hierarchy. This is the system’s anchor color and should carry the most authority.
- **Tertiary (#F2F3F4):** A pale neutral gray used as a soft background layer for cards, pages, and side panels. It keeps the interface bright and editorial.
- **Neutral (#FFFFFF):** White is the dominant surface color for hero panels, navigation, and breathing room around content. It preserves the clean clinical tone.
- **Surface (#F2F3F4):** The main surface token is a cool off-white that supports a minimal, modern institutional feel.
- **On-surface (#052049):** Dark text on light surfaces for maximum readability and a formal, composed appearance.
- **Border (#E5E7EB):** A light border tone for subtle separation when structure is needed without introducing heavy contrast.
- **Muted (#6B7280):** A restrained gray for less prominent supporting text and auxiliary metadata.
- **Error (#D92D20):** A clear, medically legible red reserved for validation, alerts, and critical states.

## Typography
The typography system is intentionally split between an editorial serif for large headlines and a clean sans-serif for everything functional. `headline-display` and `headline-lg` use GranjonLTW01-Roman with tight tracking and large sizes to create a refined, magazine-like hero presence. `headline-md` and `headline-sm` shift to Helvetica Neue Light for section titles and supporting headlines, keeping the voice modern and accessible.

Body copy uses Helvetica Neue Light with generous line height, matching the screenshot’s calm reading rhythm and making long-form research content easy to scan. `label-lg`, `label-md`, and `label-sm` are set in a medium weight for buttons, navigation, and metadata; the smallest label styles can be used for uppercase-style section markers and compact UI text. Letter spacing is subtle in body text and more pronounced in `label-sm` and `caption` for a crisp institutional accent.

## Layout
The layout is wide, centered, and content-first, with a strong hero composition followed by a modular research summary strip. Spacing is airy rather than dense, using the provided rhythm of 8px, 18px, 26px, 40px, and 60px to separate major bands of content and keep the page breathable. Sections should use large outer margins and consistent gutters so text blocks and imagery feel anchored but not crowded.

Card-like content sits on soft surfaces with modest internal padding, while the hero uses much more open framing and layered white space. The system favors fixed visual alignment and broad desktop containers over a compact grid, reflecting an institutional homepage rather than a data-heavy dashboard. Use generous vertical spacing between headline, description, and CTA to preserve the calm academic tone.

## Elevation & Depth
Depth is subtle and primarily created through overlap, contrast, and tonal separation instead of dramatic shadows. The hero card floats over the image with a clean white panel, while the surrounding page stays light and understated. Borders are faint, and shadows should remain minimal or absent; if shadow is needed, use it sparingly and with low contrast.

The main hierarchy comes from image scale, text contrast, and the strong navy-versus-blue color relationship. Flat surfaces are preferred over glossy effects, because the brand reads as composed, clinical, and confident rather than playful or tactile. When depth is needed, use layering and whitespace before introducing shadow.

## Shapes
The shape language is controlled and understated. Most elements feel squared-off or only gently softened, with `rounded.sm` reserved for cards and inputs and `rounded.full` used for pill-shaped buttons. This creates a mix of editorial sharpness and approachable utility.

Interactive elements should avoid exaggerated curves except for primary CTAs, which intentionally read as calm capsules. Overall, the system leans toward architectural clarity rather than playful rounding.

## Components
Buttons are clean, text-forward, and minimal. `button-primary` and `button-secondary` should both use pill shapes with transparent backgrounds and blue text, matching the screenshot’s outline-style CTA behavior; the key distinction is in border treatment when needed, with `button-secondary` feeling more explicitly framed. Heights should stay around `64px` for main actions, with padding concentrated horizontally and no shadow. Hover states can shift text emphasis slightly or deepen the blue, but should not introduce fills or dramatic motion.

`button-tertiary` is for inline or low-emphasis actions and should remain flat, unboxed, and compact. Links and navigation items should use the `nav` or `body` type scale and remain visually quiet until active or hovered.

Cards should be lightweight containers with `card` styling: soft gray background, fine border, small radius, and moderate padding. They are used for secondary content blocks, not promotional emphasis. Inputs should feel similarly restrained, with white or very light surfaces, subtle borders, and `rounded.sm` corners for clarity and ease of use.

Chips should be small, pill-shaped, and text-led, using blue text on a light or white background. They should support categorization and filtering without competing with primary buttons. The hero panel should remain white and flat, allowing the image behind it to carry the emotional weight of the page.

Top-level utility bars should use the deep navy `topbar` styling with small white text to establish institutional framing. Navigation links should be simple, evenly spaced, and free of heavy decoration. If icons are used, they should match the strong blue accent and maintain the same level of precision as the text.

## Do's and Don'ts
- Do use the serif headline style for the most important story-driven messaging.
- Do keep body text and navigation in clean sans-serif styles with generous line height.
- Do favor white and pale gray surfaces with navy text for high readability.
- Do reserve bright blue for links, CTAs, and key emphasis only.
- Do keep corners modest: small radii for cards and pills for primary actions.
- Don't introduce heavy shadows, gradients, or glossy visual effects.
- Don't overuse the accent blue in large fills or backgrounds.
- Don't make spacing compact; the brand should feel open, editorial, and institutional.