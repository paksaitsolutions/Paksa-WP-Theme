<?php
/**
 * Paksa IT Solutions — Contact Page
 * Template Name: Contact Us
 * @package paksa-it-solutions
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main id="main-content" class="pk-contact-page">

<!-- ═══ HERO ═══ -->
<section class="pk-contact-hero" aria-labelledby="pk-contact-h1">
    <div class="pk-contact-hero-dots" aria-hidden="true"></div>
    <div class="pk-contact-hero-glow" aria-hidden="true"></div>
    <div class="container">
        <div class="pk-contact-hero-inner">

            <div class="pk-ct-fade">
                <div class="pk-contact-hero-eyebrow">
                    <?php echo paksa_icon( 'lightning', 14 ); ?>
                    Get in Touch
                </div>
                <h1 id="pk-contact-h1" class="pk-contact-hero-h1">
                    Let's Build Something<br><span>That Actually Works</span>
                </h1>
                <p class="pk-contact-hero-desc">
                    Tell us what you're trying to solve. We'll respond within one business day with honest advice — not a sales pitch.
                </p>
                <div class="pk-contact-hero-trust">
                    <div class="pk-contact-hero-trust-item">
                        <div class="pk-contact-hero-trust-icon"><?php echo paksa_icon( 'check', 16 ); ?></div>
                        No commitment required for the first conversation
                    </div>
                    <div class="pk-contact-hero-trust-item">
                        <div class="pk-contact-hero-trust-icon"><?php echo paksa_icon( 'shield', 16 ); ?></div>
                        Your information is never shared with third parties
                    </div>
                    <div class="pk-contact-hero-trust-item">
                        <div class="pk-contact-hero-trust-icon"><?php echo paksa_icon( 'users', 16 ); ?></div>
                        You speak directly with our technical team — not a sales rep
                    </div>
                </div>
            </div>

            <div class="pk-contact-hero-card pk-ct-fade" data-delay="120">
                <div class="pk-contact-response-badge">Typically responds within 4 hours</div>
                <div class="pk-contact-hero-stats">
                    <div class="pk-contact-hero-stat">
                        <div class="pk-contact-hero-stat-val">50+</div>
                        <div class="pk-contact-hero-stat-label">Projects delivered</div>
                    </div>
                    <div class="pk-contact-hero-stat">
                        <div class="pk-contact-hero-stat-val">8+</div>
                        <div class="pk-contact-hero-stat-label">Industries served</div>
                    </div>
                    <div class="pk-contact-hero-stat">
                        <div class="pk-contact-hero-stat-val">100%</div>
                        <div class="pk-contact-hero-stat-label">In-house team</div>
                    </div>
                    <div class="pk-contact-hero-stat">
                        <div class="pk-contact-hero-stat-val">5★</div>
                        <div class="pk-contact-hero-stat-label">Client satisfaction</div>
                    </div>
                </div>
                <div class="pk-contact-channels">
                    <a href="mailto:info@paksa.com.pk" class="pk-contact-channel">
                        <div class="pk-contact-channel-icon pk-contact-channel-icon--email">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <div>
                            <div class="pk-contact-channel-label">Email</div>
                            <div class="pk-contact-channel-value">info@paksa.com.pk</div>
                        </div>
                    </a>
                    <a href="tel:+923057772572" class="pk-contact-channel">
                        <div class="pk-contact-channel-icon pk-contact-channel-icon--phone">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <div class="pk-contact-channel-label">Phone / WhatsApp</div>
                            <div class="pk-contact-channel-value">+92 305 777 2572</div>
                        </div>
                    </a>
                    <a href="https://wa.me/923057772572" class="pk-contact-channel" target="_blank" rel="noopener">
                        <div class="pk-contact-channel-icon pk-contact-channel-icon--whatsapp">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                        </div>
                        <div>
                            <div class="pk-contact-channel-label">WhatsApp</div>
                            <div class="pk-contact-channel-value">Chat with us now</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══ MAIN: FORM + SIDEBAR ═══ -->
<section class="pk-contact-main">
    <div class="container">
        <div class="pk-contact-main-inner">

            <!-- Form card -->
            <div class="pk-contact-form-card pk-ct-fade">
                <h2 class="pk-contact-form-title">Send Us a Message</h2>
                <p class="pk-contact-form-subtitle">Fill in the details below and we'll get back to you within one business day. The more context you give us, the more useful our response will be.</p>

                <!-- Interest selector -->
                <div class="pk-contact-interests" role="group" aria-label="What are you interested in?">
                    <button type="button" class="pk-contact-interest-btn" data-value="AI & Machine Learning">AI & ML</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="AI Automation">AI Automation</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="Data Science">Data Science</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="ERP System">ERP System</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="Custom Software">Custom Software</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="Web Application">Web App</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="System Integration">Integration</button>
                    <button type="button" class="pk-contact-interest-btn" data-value="Consulting">Consulting</button>
                </div>

                <!-- Notices -->
                <div id="pk-cf-success" class="pk-cf-notice pk-cf-notice--success" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Message sent — we'll be in touch within one business day.</span>
                </div>
                <div id="pk-cf-error" class="pk-cf-notice pk-cf-notice--error" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Something went wrong. Please email us directly at <a href="mailto:info@paksa.com.pk">info@paksa.com.pk</a>.</span>
                </div>

                <form id="pk-contact-form" novalidate>
                    <?php wp_nonce_field( 'paksa_contact_nonce', 'pk_nonce' ); ?>
                    <input type="text" name="pk_hp" class="pk-cf-honeypot" tabindex="-1" autocomplete="off">
                    <input type="hidden" id="pk-cf-interests-val" name="interests" value="">

                    <div class="pk-cf-grid">
                        <div class="pk-cf-group">
                            <label class="pk-cf-label" for="pk-cf-name">Full Name <span aria-hidden="true">*</span></label>
                            <input type="text" id="pk-cf-name" name="name" class="pk-cf-input" placeholder="Muhammad Ali" required autocomplete="name">
                        </div>
                        <div class="pk-cf-group">
                            <label class="pk-cf-label" for="pk-cf-email">Work Email <span aria-hidden="true">*</span></label>
                            <input type="email" id="pk-cf-email" name="email" class="pk-cf-input" placeholder="ali@company.com" required autocomplete="email">
                        </div>
                        <div class="pk-cf-group">
                            <label class="pk-cf-label" for="pk-cf-company">Company / Organisation</label>
                            <input type="text" id="pk-cf-company" name="company" class="pk-cf-input" placeholder="Your company name" autocomplete="organization">
                        </div>
                        <div class="pk-cf-group">
                            <label class="pk-cf-label" for="pk-cf-phone">Phone Number</label>
                            <input type="tel" id="pk-cf-phone" name="phone" class="pk-cf-input" placeholder="+92 300 0000000" autocomplete="tel">
                        </div>
                        <div class="pk-cf-group pk-cf-full">
                            <label class="pk-cf-label" for="pk-cf-service">Service You're Interested In <span aria-hidden="true">*</span></label>
                            <select id="pk-cf-service" name="service" class="pk-cf-select" required>
                                <option value="" disabled selected>Select a service...</option>
                                <option>AI &amp; Machine Learning Solutions</option>
                                <option>AI Process Automation</option>
                                <option>Data Science &amp; Analytics</option>
                                <option>Business Intelligence &amp; Reporting</option>
                                <option>Enterprise Resource Planning (ERP)</option>
                                <option>Custom Software Development</option>
                                <option>SaaS Product Development</option>
                                <option>System Integration &amp; APIs</option>
                                <option>Ecommerce Solutions</option>
                                <option>Web Application Development</option>
                                <option>Digital Transformation Consulting</option>
                                <option>Not sure — need advice</option>
                            </select>
                        </div>
                        <div class="pk-cf-group pk-cf-full">
                            <label class="pk-cf-label" for="pk-cf-budget">Approximate Budget</label>
                            <div class="pk-cf-budget-wrap">
                                <div class="pk-cf-budget-display">
                                    <span id="pk-cf-budget-display" class="pk-cf-budget-val">$5,000</span>
                                    <span class="pk-cf-budget-label">Drag to set range</span>
                                </div>
                                <input type="range" id="pk-cf-budget" name="budget" class="pk-cf-range" min="1000" max="100000" step="1000" value="5000">
                            </div>
                        </div>
                        <div class="pk-cf-group pk-cf-full">
                            <label class="pk-cf-label" for="pk-cf-message">Tell Us About Your Project <span aria-hidden="true">*</span></label>
                            <textarea id="pk-cf-message" name="message" class="pk-cf-input pk-cf-textarea" placeholder="Describe what you're trying to build or solve. The more detail you give us, the more useful our response will be — what's the problem, what have you tried, what does success look like?" required></textarea>
                        </div>
                        <div class="pk-cf-group pk-cf-full">
                            <label class="pk-cf-label" for="pk-cf-timeline">Project Timeline</label>
                            <select id="pk-cf-timeline" name="timeline" class="pk-cf-select">
                                <option value="" disabled selected>When do you need this?</option>
                                <option>As soon as possible</option>
                                <option>Within 1 month</option>
                                <option>1–3 months</option>
                                <option>3–6 months</option>
                                <option>6+ months / planning phase</option>
                                <option>Not sure yet</option>
                            </select>
                        </div>
                    </div>

                    <div class="pk-cf-submit-row">
                        <p class="pk-cf-privacy">By submitting you agree to our <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>. We never share your data.</p>
                        <button type="submit" class="pk-cf-submit">
                            <span class="pk-cf-submit-text">Send Message</span>
                            <span class="pk-cf-spinner" aria-hidden="true"></span>
                            <svg class="pk-cf-submit-text" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <aside class="pk-contact-sidebar pk-ct-fade" data-delay="100">

                <!-- Contact info -->
                <div class="pk-contact-info-card">
                    <h3 class="pk-contact-info-card-title">
                        <?php echo paksa_icon( 'network', 16 ); ?>
                        Contact Information
                    </h3>
                    <ul class="pk-contact-info-list">
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon pk-contact-info-icon--blue">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </div>
                            <div>
                                <div class="pk-contact-info-label">General Enquiries</div>
                                <div class="pk-contact-info-value"><a href="mailto:info@paksa.com.pk">info@paksa.com.pk</a></div>
                            </div>
                        </li>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon pk-contact-info-icon--purple">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </div>
                            <div>
                                <div class="pk-contact-info-label">Sales</div>
                                <div class="pk-contact-info-value"><a href="mailto:sales@paksa.com.pk">sales@paksa.com.pk</a></div>
                            </div>
                        </li>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon pk-contact-info-icon--green">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div>
                                <div class="pk-contact-info-label">Phone / WhatsApp</div>
                                <div class="pk-contact-info-value"><a href="tel:+923057772572">+92 305 777 2572</a></div>
                            </div>
                        </li>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon pk-contact-info-icon--amber">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div>
                                <div class="pk-contact-info-label">Office</div>
                                <div class="pk-contact-info-value">PIA Housing Society,<br>Lahore, Pakistan</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Office hours -->
                <div class="pk-contact-info-card">
                    <h3 class="pk-contact-info-card-title">
                        <?php echo paksa_icon( 'lightning', 16 ); ?>
                        Office Hours
                    </h3>
                    <div class="pk-contact-hours">
                        <div class="pk-contact-hours-row">
                            <span class="pk-contact-hours-day">Monday – Friday</span>
                            <span class="pk-contact-hours-time">9:00 AM – 6:00 PM PKT</span>
                        </div>
                        <div class="pk-contact-hours-row">
                            <span class="pk-contact-hours-day">Saturday</span>
                            <span class="pk-contact-hours-time">10:00 AM – 2:00 PM PKT</span>
                        </div>
                        <div class="pk-contact-hours-row">
                            <span class="pk-contact-hours-day">Sunday</span>
                            <span class="pk-contact-hours-closed">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Social -->
                <div class="pk-contact-info-card">
                    <h3 class="pk-contact-info-card-title">
                        <?php echo paksa_icon( 'network', 16 ); ?>
                        Follow Us
                    </h3>
                    <div class="pk-contact-social">
                        <a href="https://linkedin.com/company/paksaitsolutions" class="pk-contact-social-link" target="_blank" rel="noopener">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                            LinkedIn
                        </a>
                        <a href="https://github.com/paksaitsolutions" class="pk-contact-social-link" target="_blank" rel="noopener">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                            GitHub
                        </a>
                        <a href="https://wa.me/923057772572" class="pk-contact-social-link" target="_blank" rel="noopener">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</section>

<!-- ═══ WHAT HAPPENS NEXT ═══ -->
<section class="pk-contact-process">
    <div class="container">
        <span class="pk-contact-process-label pk-ct-fade">What Happens Next</span>
        <h2 class="pk-contact-process-h2 pk-ct-fade" data-delay="60">From First Message to First Delivery</h2>
        <div class="pk-contact-process-steps">
            <div class="pk-contact-process-step pk-ct-fade" data-delay="0">
                <div class="pk-contact-process-num" aria-hidden="true">01</div>
                <h3 class="pk-contact-process-title">We Read Your Message Carefully</h3>
                <p class="pk-contact-process-desc">Every enquiry is reviewed by a technical team member — not filtered by a sales team. We read what you've written before we respond.</p>
            </div>
            <div class="pk-contact-process-step pk-ct-fade" data-delay="80">
                <div class="pk-contact-process-num" aria-hidden="true">02</div>
                <h3 class="pk-contact-process-title">Discovery Call — No Pitch</h3>
                <p class="pk-contact-process-desc">We schedule a 30–45 minute call to understand your problem in depth. We ask questions. We listen. We tell you honestly if we're the right fit.</p>
            </div>
            <div class="pk-contact-process-step pk-ct-fade" data-delay="160">
                <div class="pk-contact-process-num" aria-hidden="true">03</div>
                <h3 class="pk-contact-process-title">Scoped Proposal Within 3 Days</h3>
                <p class="pk-contact-process-desc">We send a clear, detailed proposal — scope, timeline, team, cost. No vague estimates. No hidden fees. Everything in writing before any work begins.</p>
            </div>
            <div class="pk-contact-process-step pk-ct-fade" data-delay="240">
                <div class="pk-contact-process-num" aria-hidden="true">04</div>
                <h3 class="pk-contact-process-title">We Start Building</h3>
                <p class="pk-contact-process-desc">Once agreed, we kick off with a structured onboarding. You get a dedicated point of contact, a project board and working deliverables every two weeks.</p>
            </div>
        </div>
    </div>
</section>

</main>
<?php get_footer(); ?>
