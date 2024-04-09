<?php
/**
 * Event Submission Form
 * The wrapper template for the event submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/edit-event.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since 3.1
 * @since 4.8.2 Updated template link.
 * @since 4.8.10 Use datepicker format from the date utils library to autofill the start and end dates.
 *
 * @version 4.8.10
 *
 * @var int|string $tribe_event_id
 */

if (!defined('ABSPATH')) {
    die('-1');
}

if (!isset($tribe_event_id)) {
    $tribe_event_id = null;
}

$datepicker_format = Tribe__Date_Utils::get_datepicker_format_index();

/** @var Tribe__Events__Community__Main $main */
$main = tribe('community.main');

// Variables for Title view.
$events_label_singular = tribe_get_event_label_singular();

// Variables for the Terms view.
$terms_enabled = $main->getOption('termsEnabled');

$terms_description = $main->getOption('termsDescription');

// Variables for the Website view.
$event_url = $_POST['EventURL'] ?? tribe_get_event_website_url();
$event_url = esc_attr($event_url);

?>


<?php tribe_get_template_part('community/modules/header-links'); ?>

<?php do_action('tribe_events_community_form_before_template', $tribe_event_id); ?>


<div class="event-section__form_link">
    <a href="#basic-section" class="section-toggle" data-target="basic-section">Basic Details</a>
    <a href="#venue-and-organizer-section" class="section-toggle" data-target="venue-and-organizer-section">Advanced
        Details</a>
    <a href="#cost-section" class="section-toggle" data-target="cost-section">Tickets</a>

    <a href="#submit-section" class="section-toggle" data-target="submit-section">Submit</a>
</div>

<form method="post" enctype="multipart/form-data"
    data-datepicker_format="<?php echo esc_attr($datepicker_format); ?>">
    <input type="hidden" name="post_ID" id="post_ID" value="<?php echo absint($tribe_event_id); ?>" />
    <?php wp_nonce_field('ecp_event_submission'); ?>

    <div id="basic-section" class="event-section">
        <?php tribe_get_template_part('community/modules/image'); ?>
        <?php tribe_get_template_part('community/modules/title', null, ['events_label_singular' => $events_label_singular]); ?>
        <?php tribe_get_template_part('community/modules/description'); ?>
        <?php tribe_get_template_part('community/modules/datepickers'); ?>
        <?php tribe_get_template_part('community/modules/taxonomy', null, ['taxonomy' => Tribe__Events__Main::TAXONOMY]); ?>
        <?php tribe_get_template_part('community/modules/taxonomy', null, ['taxonomy' => 'post_tag']); ?>
        <?php tribe_get_template_part('community/modules/venue'); ?>
        <?php tribe_get_template_part('community/modules/organizer'); ?>
        <button class="next-section-btn" data-target="venue-and-organizer-section">Next</button>
    </div>





    <div id="venue-and-organizer-section" class="event-section" style="display: none;">



        <?php tribe_get_template_part('community/modules/website', null, ['event_url' => $event_url]); ?>
        <?php tribe_get_template_part('community/modules/series'); ?>
        <?php tribe_get_template_part('community/modules/custom'); ?>


        <!-- Sponsor section -->
        <div class="event_decp_div hover_section">
            <h2>Event Sponsors</h2>
            <p>Boost your brand's visibility as an event sponsor, guiding attendees to your contributions.</p>
            <div id="event_sponsors" class="hover_section_content_show">
                <?php
                // Retrieve and display existing sponsor logos
                $sponsor_logos_ids = get_post_meta($tribe_event_id, 'event_sponsor_logo');
                foreach ($sponsor_logos_ids as $logo_id) {
                    $logo_url = wp_get_attachment_url($logo_id);
                    echo '<div class="sponsor_logo_container">';
                    echo '<img src="' . esc_url($logo_url) . '" alt="Sponsor Logo" class="existing_sponsor_logo">';
                    echo '</div>'; // Close .sponsor_logo_container
                    echo '<button type="button" class="remove_sponsor_logo" data-logo-id="' . esc_attr($logo_id) . '" data-event-id="' . esc_attr($tribe_event_id) . '" data-nonce="' . wp_create_nonce('remove_sponsor_logo_nonce') . '">Delete</button>';
                }
                ?>
                <button id="add_sponsor_button" type="button">Add Sponsor</button>
            </div> <!-- Close #event_sponsors -->
            <!-- Close .event_decp_div -->
        </div>

        <!-- AGENDA section -->
        <div class="event_decp_div hover_section agenda_section_admin">
            <h2>Event Agenda</h2>
            <p>Add an itinerary, schedule, or lineup to your event...</p>
            <div class="admin_agenda_agenda-items-wrapper">
                <div id="admin_agenda_agenda-items-container" class="hover_section_content_show">
                    <?php
                    $event_id = get_the_ID();
                    $agendas = get_post_meta($event_id, 'event_agendas', true) ?: [];
                    foreach ($agendas as $index => $agenda) {
                        echo '<div class="admin_agenda_agenda-item" data-index="' . $index . '">';
                        echo '<div class="admin_agenda_accordion-header"><span class="admin_agenda_accordion-title">' . esc_html($agenda['title'] ?? 'New Agenda Item') . '</span> <span class="admin_agenda_accordion-arrow">+</span></div>';
                        echo '<div class="admin_agenda_accordion-content">';
                        echo '<div class="admin_agenda_time_contnt">';
                        echo '<p><label for="admin_agenda_event_agendas_time_from_' . $index . '">Time From:</label><input type="time" id="admin_agenda_event_agendas_time_from_' . $index . '" name="event_agendas[' . $index . '][time_from]" value="' . esc_attr($agenda['time_from'] ?? '') . '" /></p>';
                        echo '<p><label for="admin_agenda_event_agendas_time_to_' . $index . '">Time To:</label><input type="time" id="admin_agenda_event_agendas_time_to_' . $index . '" name="event_agendas[' . $index . '][time_to]" value="' . esc_attr($agenda['time_to'] ?? '') . '" /></p>';
                        echo '</div>';
                        echo '<p><label for="admin_agenda_event_agendas_title_' . $index . '"></label><input type="text" class="admin_agenda_event_agendas_title" id="admin_agenda_event_agendas_title_' . $index . '" name="event_agendas[' . $index . '][title]" value="' . esc_attr($agenda['title'] ?? '') . '" /></p>';
                        echo '<button type="button" class="admin_agenda_remove-agenda admin_delect_btn_all">Delete</button>';

                        echo '</div>'; // Close .admin_agenda_accordion-content
                        echo '</div>'; // Close .admin_agenda_agenda-item
                    }
                    ?>
                </div>
            </div>
            <button type="button" id="admin_agenda_add-agenda"
                class="admin_add_btn_all admin_agenda_add-agenda-button hover_section_content_show">Add Agenda</button>
            <?php wp_nonce_field('save_event_agendas', 'admin_agenda_event_agendas_nonce'); ?>
        </div>

        <!-- LINE UP section -->
        <div class="event_decp_div hover_section line_up_section_admin">
            <h2>Event Line-up</h2>
            <p>Add artists, speakers, or performers for your event.</p>
            <div class="hover_section_content_show">
                <div id="line-up-items-container">
                    <?php
                    $event_id = get_the_ID();
                    $line_up = get_post_meta($event_id, 'event_line_up', true) ?: [];
                    foreach ($line_up as $index => $item) {
                        ?>
                        <div class="line-up-item" data-index="<?php echo $index; ?>">
                            <label for="line_up_<?php echo $index; ?>_name"></label>
                            <input placeholder="Name" type="text" id="line_up_<?php echo $index; ?>_name"
                                name="event_line_up[<?php echo $index; ?>][name]"
                                value="<?php echo esc_attr($item['name']); ?>" />
                            <button type="button" class="remove-line-up-item admin_delect_btn_all">Delete</button>
                        </div> <!-- Close line-up-item -->
                        <?php
                    }
                    ?>
                </div> <!-- Close line-up-items-container -->
                <button type="button" id="add-line-up-item" class="admin_add_btn_all">Add Line-up Item</button>
            </div> <!-- Close hover_section_content_show -->

        </div> <!-- Close hover_section_content_show outside -->
        <?php wp_nonce_field('save_event_line_up', 'event_line_up_nonce'); ?>
        <!-- Close event_decp_div -->



        <!-- FAQ section -->
        <div class="event_decp_div hover_section faq_section_admin">
            <h2>Event FAQ</h2>
            <p>Answer questions your attendees may have about the event, like parking, accessibility, and refunds.</p>
            <div id="event_faq" class="hover_section_content_show">
                <?php
                $event_id = get_the_ID(); // Ensure to get the correct event ID
                $faqs = get_post_meta($event_id, 'event_faqs', true) ?: [];
                echo '<div id="event-faqs-wrapper">';
                echo '<div id="faq-items-container">';
                foreach ($faqs as $index => $faq) {
                    echo '<div class="faq-item" data-index="' . $index . '">';
                    echo '<div class="accordion-title"><label></label><span>' . esc_html($faq['question']) . '</span></div>';
                    echo '<div class="accordion-content" style="display: none;">';
                    echo '<p><label for="event_faqs_question_' . $index . '"></label><input type="text" name="event_faqs[' . $index . '][question]" value="' . esc_attr($faq['question']) . '" /></p>';
                    echo '<p><label for="event_faqs_answer_' . $index . '"></label><textarea name="event_faqs[' . $index . '][answer]">' . esc_textarea($faq['answer']) . '</textarea></p>';
                    echo '<button type="button" class="remove-faq admin_delect_btn_all">Delete</button>';
                    echo '</div>'; // Close accordion-content
                    echo '</div>'; // Close faq-item
                }
                echo '</div>'; // Close faq-items-container
                echo '<button type="button" class="admin_add_btn_all" id="add-faq">Add FAQ</button>';
                echo '</div>'; // Close event-faqs-wrapper
                wp_nonce_field('save_event_faqs', 'event_faqs_nonce');
                ?>
            </div>
            <!-- Close event_faq -->
            <!-- Close event_decp_div -->
        </div>


<?php
$event_description = get_post_meta($event_id, 'event_description', true);
?>


</script>



       









        <!-- extra options section -->
        <div class="event_decp_div hover_section extra_options_section">
            <h2>Event Extra Information</h2>
            <p>Clarify your event's age limits and refund policy here to ensure attendees understand the guidelines,
                ensuring a seamless event experience.</p>
            <div id="event_extra_option" class="hover_section_content_show">
                <p>Select the relevant options below that apply to your event.</p>

                <div class="admin_event_extra_info_inputs">
                    <div class="admin_event_extra_info_input">

                    <input type="checkbox" id="allage" name="allage" <?php checked(get_post_meta($event_id, 'allage', true), 'on'); ?> />
                        <label for="allage">Event for All Ages?</label>
                        </div>


                        <div class="admin_event_extra_info_input">
                        <input type="checkbox" id="over14" name="over14" <?php checked(get_post_meta($event_id, 'over14', true), 'on'); ?> />
                        <label for="over14">Event for over 14+ </label>
                    </div>

                    <div class="admin_event_extra_info_input">
                        <input type="checkbox" id="over15" name="over15" <?php checked(get_post_meta($event_id, 'over15', true), 'on'); ?> />
                        <label for="over15">Event for over 15+</label>
                    </div>

                    <div class="admin_event_extra_info_input">
                        <input type="checkbox" id="over18" name="over18" <?php checked(get_post_meta($event_id, 'over18', true), 'on'); ?> />
                        <label for="over18">Event for over 18+</label>
                    </div>

                    <div class="admin_event_extra_info_input">
                        <input type="checkbox" id="norefunds" name="norefunds" <?php checked(get_post_meta($event_id, 'norefunds', true), 'on'); ?> />
                        <label for="norefunds">Accept refund ?</label>
                    </div>
                </div>
            </div>
            <?php wp_nonce_field('save_event_extra_options', 'event_extra_options_nonce'); ?>
        </div>











        <button class="next-section-btn" data-target="cost-section">Next</button>







    </div>








    <div id="cost-section" class="event-section" style="display: none;">
        <?php tribe_get_template_part('community/modules/cost'); ?>

        <!-- <div class="input-group date" id="reservationdate" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">
            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div> -->

        <?php tribe_get_template_part('community/modules/spam-control'); ?>
        <button class="next-section-btn" data-target="submit-section">Next</button>
    </div>

    <div id="submit-section" class="submit-section" style="display: none;">
        <?php tribe_get_template_part('community/modules/terms', null, ['terms_enabled' => $terms_enabled, 'terms_description' => $terms_description]); ?>
        <?php tribe_get_template_part('community/modules/submit'); ?>
    </div>





</form>



<?php do_action('tribe_events_community_form_after_template', $tribe_event_id); ?>





<script>






    /////FUNCTION FOR LINE UPS 
    jQuery(document).ready(function ($) {
        var container = $('#line-up-items-container');
        var index = <?php echo count($line_up); ?>; // Start the new index after the existing items

        $('#add-line-up-item').on('click', function () {
            var newItemHtml = `
            <div class="line-up-item" data-index="${index}">
                <label for="line_up_${index}_name"></label>
                <input  placeholder="Name" type="text" id="line_up_${index}_name" name="event_line_up[${index}][name]" />
                <button type="button" class="remove-line-up-item admin_delect_btn_all">Delete</button>
            </div>`;
            container.append(newItemHtml);
            index++;
        });

        container.on('click', '.remove-line-up-item', function () {
            $(this).closest('.line-up-item').remove();
        });
    });




    ////////FUNCTION FOR THE AGENDA SECTION
    jQuery(document).ready(function ($) {
        var container = $('#admin_agenda_agenda-items-container');
        var index = <?php echo count($agendas); ?>; // Get the current count of agenda items

        // Function to add accordion functionality
        function setupAccordion() {
            $('.admin_agenda_accordion-header').off('click').on('click', function () {
                var arrow = $(this).find('.admin_agenda_accordion-arrow');
                // Toggle between "+" and "-" for the arrow text
                arrow.text(arrow.text() === '+' ? '-' : '+');
                // Slide toggle the accordion content
                $(this).next('.admin_agenda_accordion-content').slideToggle();
            });
        }

        // Initialize the accordion for existing items if more than one
        setupAccordion();

        // Event handler for title input change to update the accordion header
        container.on('input', '.admin_agenda_event_agendas_title', function () {
            var title = $(this).val().trim();
            $(this).closest('.admin_agenda_agenda-item').find('.admin_agenda_accordion-title').text(title || 'New Agenda Item');
        });

        $('#admin_agenda_add-agenda').on('click', function () {
            // HTML for the new agenda item
            var newItemHtml = `
            <div class="admin_agenda_agenda-item" data-index="${index}">
                <div class="admin_agenda_accordion-header">
                    <span class="admin_agenda_accordion-title">New Agenda Item</span> 
                    <span class="admin_agenda_accordion-arrow">+</span>
                </div>
                <div class="admin_agenda_accordion-content">
                    <p><label for="admin_agenda_event_agendas_title_${index}"></label><input type="text" placeholder="Title" class="admin_agenda_event_agendas_title" id="admin_agenda_event_agendas_title_${index}" name="event_agendas[${index}][title]" /></p>
                    <div class="admin_agenda_time_contnt">
                    <p><label for="admin_agenda_event_agendas_time_from_${index}">Time From:</label><input placeholder="test" type="time" id="admin_agenda_event_agendas_time_from_${index}" name="event_agendas[${index}][time_from]" /></p>
                    <p><label for="admin_agenda_event_agendas_time_to_${index}">Time To:</label><input type="time" id="admin_agenda_event_agendas_time_to_${index}" name="event_agendas[${index}][time_to]" /></p>
                    </div>
                    <button type="button" class="admin_agenda_remove-agenda admin_delect_btn_all">Delete</button>
                </div>
            </div>`;
            container.append(newItemHtml);
            index++;

            // Apply accordion functionality as soon as there's more than one item
            setupAccordion();
        });

        container.on('click', '.admin_agenda_remove-agenda', function () {
            $(this).closest('.admin_agenda_agenda-item').remove();
            index--;

            // If only one item remains, show it and remove accordion functionality
            if (index <= 1) {
                $('.admin_agenda_accordion-content').show();
                $('.admin_agenda_accordion-arrow').text('+'); // Reset arrow to "+"
            } else {
                // Reinitialize the accordion for all items
                setupAccordion();
            }
        });
    });






    //////// FUNCTION FOR THE FAQ SECTION 
jQuery(document).ready(function ($) {
    var container = $('#faq-items-container');
    var index = <?php echo count($faqs); ?>;
    var maxCharCount = 200; // Maximum character count per individual FAQ

    // Function to collapse all accordion contents
    function collapseAll() {
        $('.accordion-content').slideUp();
        $('.accordion-title').removeClass('active'); // Remove the active class from all titles
    }

    // Function to add a new FAQ item
    $('#add-faq').on('click', function () {
        // Collapse all accordion contents
        collapseAll();

        // Create new item
        var newItemHtml = `
        <div class="faq-item" data-index="${index}">
            <div class="accordion-title">
              <span class="question-title">New Question</span>
            </div>
            <div class="accordion-content" style="display: none;">
                <p><label for="event_faqs_question_${index}"></label>
                <input type="text" name="event_faqs[${index}][question]" class="faq-question-input" placeholder="Question" /></p>
                <p>
                    <label for="event_faqs_answer_${index}"></label>
                    <textarea name="event_faqs[${index}][answer]" placeholder="Answer" class="faq-answer-input"></textarea>
                </p>
                <span class="char-count" id="char-count-${index}">0/${maxCharCount}</span>
                <span class="char-limit-warning" id="char-limit-warning-${index}"></span>
                <button type="button" class="remove-faq admin_delect_btn_all">Delete</button>
            </div>
        </div>`;

        // Append the new item and slide it down
        var newItem = $(newItemHtml).appendTo(container);
        newItem.find('.accordion-content').slideDown();
        newItem.find('.accordion-title').addClass('active'); // Add the active class to the new title
        index++;
    });

    // Event handler for toggling accordion contents
    container.on('click', '.accordion-title', function () {
        var content = $(this).next('.accordion-content');
        var wasOpen = content.is(':visible');

        // Collapse all others
        collapseAll();

        // If it was already open, we leave it closed. Otherwise, open it.
        if (!wasOpen) {
            content.slideDown();
            $(this).addClass('active'); // Add the active class to the clicked title
        }
    });

    // Event handler for updating the title text
    container.on('keyup', '.faq-question-input', function () {
        var title = $(this).closest('.faq-item').find('.question-title');
        title.text($(this).val());
    });

    // Event handler for removing an FAQ item
    container.on('click', '.remove-faq', function () {
        $(this).closest('.faq-item').remove();
    });

    // Function to count characters and update the counter
    function updateCharCountAndLimit(textarea, index) {
        var charCount = textarea.value.length;
        var charCountElement = $('#char-count-' + index);
        var charLimitWarningElement = $('#char-limit-warning-' + index);

        charCountElement.text(charCount + '/' + maxCharCount);

        if (charCount > maxCharCount) {
            // Trim the string to the first 200 characters
            var trimmedString = textarea.value.slice(0, maxCharCount);
            textarea.value = trimmedString;
            charCountElement.text(maxCharCount + '/' + maxCharCount);
            charLimitWarningElement.text('Character limit exceeded').css('color', 'red');
        } else {
            charLimitWarningElement.text('');
        }
    }

    // Event handler for character count update
    container.on('input', '.faq-answer-input', function () {
        var index = $(this).closest('.faq-item').data('index');
        updateCharCountAndLimit(this, index);
    });

    // Initial check on page load for existing textareas
    $('.faq-answer-input').each(function () {
        var index = $(this).closest('.faq-item').data('index');
        updateCharCountAndLimit(this, index);
    });
});







    /////function to add the progess bar 


    jQuery(document).ready(function ($) {
        // Initially hide all sections except the first
        $('.event-section').not('#basic-section').hide();

        // Update progress bar
        function updateProgressBar(targetIndex) {
            $('.section-toggle').removeClass('active').removeClass('completed');
            $('.section-toggle').each(function (index) {
                if (index < targetIndex) {
                    $(this).addClass('completed');
                } else if (index === targetIndex) {
                    $(this).addClass('active');
                }
            });
        }

        // Handle click event on section links
        $('.section-toggle').click(function (e) {
            e.preventDefault();

            var targetSection = '#' + $(this).data('target');
            var targetIndex = $('.section-toggle').index(this);

            // Hide all sections and show the clicked one
            $('.event-section').hide();
            $(targetSection).show();

            // Update progress bar
            updateProgressBar(targetIndex);

            // Scroll to the top of the target section
            $('html, body').animate({
                scrollTop: $(targetSection).offset().top
            }, 500);
        });

        // Handle click event on Next button
        $('.next-section-btn').click(function (e) {
            e.preventDefault();

            var currentSection = $(this).closest('.event-section');
            var targetSection = '#' + $(this).data('target');
            var targetIndex = $('.section-toggle').index($('.section-toggle[data-target="' + $(this).data('target') + '"]'));

            // Hide current section and show the next section
            currentSection.hide();
            $(targetSection).show();

            // Update progress bar
            updateProgressBar(targetIndex);

            // Scroll to the top of the next section
            $('html, body').animate({
                scrollTop: $(targetSection).offset().top
            }, 500);
        });

        // Initialize progress bar
        updateProgressBar(0);
    });








    //TITLE PLACEHONDER FUNCTION 

    document.addEventListener("DOMContentLoaded", function () {
        // Set placeholder for the 'Event Title' input
        var titleInput = document.getElementById('post_title');
        if (titleInput) {
            titleInput.setAttribute('placeholder', 'Event Title');
        }
    });







    ////FUNCTION TO ADD A EDIT ICON ON HOVE AND SHOW THE SECTIONS 
    jQuery(document).ready(function () {
        // Define the SVG markup with the 'svg_penlic_edit' class added
        var svgHtml = '<svg class="hover_svg svg_penlic_edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>';

        // Hover event for the section
        jQuery('.hover_section').hover(
            function () {
                // Check if the 'displayed' class is present in the content
                if (!jQuery(this).find('.events-community-post-content.displayed, .hover_section_content_show.displayed').length) {
                    // 'displayed' class not found, add the SVG
                    jQuery(this).prepend(svgHtml);
                }
            },
            function () {
                // Always remove the SVG on hover out
                jQuery(this).find('.hover_svg').remove();
            }
        );

        // Click event for the section
        jQuery('.hover_section').click(function (event) {
            // Prevent click from propagating to higher elements
            event.stopPropagation();

            // Check if the clicked section is already active
            if (jQuery(this).hasClass('clicked-section_new')) {
                // If it's already active, do nothing further
                return;
            }

            // Remove 'clicked-section' class from all sections and add to the clicked one
            jQuery('.hover_section').removeClass('clicked-section');
            jQuery(this).addClass('clicked-section');

            // Hide previously displayed content and show for the clicked section
            jQuery('.events-community-post-content.displayed, .hover_section_content_show.displayed').removeClass('displayed').hide();
            jQuery(this).find('.events-community-post-content, .hover_section_content_show').addClass('displayed').show();

            console.log('Content display toggled for clicked section.');
        });



    });



    /////FUNCTION WHEN CLICK THE TITLE SECTION IT WOULD ADD THE TYEPING EFFTECT 
    jQuery(document).ready(function () {
        // Click event for the element with class 'event_title_click_fuction'
        jQuery('.event_title_click_fuction').click(function () {
            // Focus the input field inside the clicked element
            var inputField = jQuery(this).find('.events-community-post-title input[type="text"]');
            inputField.focus();

            // Check if the input field is empty or has the placeholder text before adding the desired string
            if (inputField.val() === '' || inputField.val() === inputField.attr('placeholder')) {
                inputField.val(''); // Replace 'Your New Value' with the desired string
            }
        });
    });









    //FUNCTION TO USE THEUPLOADED IMAGE ON THE DIV AS BANNER 
    jQuery(document).ready(function ($) {
        $('#event_image').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Set the background image of the .tribe-image-upload-area div
                    $('.tribe-image-upload-area').css('background-image', 'url(' + e.target.result + ')');
                    // Hide the <h2> and <p> elements
                    $('.tribe-image-upload-area').find('.note').hide();
                };

                // Read the selected file
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Click event for the .tribe-remove-upload link
        $('.tribe-remove-upload').click(function (e) {
            e.preventDefault(); // Prevent the default action of the link
            jQuery('#event_image').val() = '';
            // Remove the background image from the .tribe-image-upload-area div
            $('.tribe-image-upload-area').css('background-image', 'none');
            // Show the <h2> and <p> elements again
            $('.tribe-image-upload-area').find('.note').show();
        });




    });


    ///FUNCTION TO CHANGE THE EDIT LINK WHE EVENT IS SUBMEITED OR UPDATED 
    jQuery(document).ready(function ($) {
        // Function to execute when the desired element is found
        function updateEditLink() {
            var editLink = $('.tribe-community-notice-update .edit-event');
            var href = editLink.attr('href');

            // Extract the ID from the href using a regular expression
            var match = href.match(/\/edit\/(\d+)\//);
            if (match && match[1]) {
                var id = match[1];
                var newHref = '/organizer-edit-event/?event_id=' + id;
                editLink.attr('href', newHref);
                console.log("Edit link updated:", newHref);
            } else {
                console.log("No match found in the href.");
            }
        }

        // Options for the observer (which mutations to observe)
        var config = { childList: true, subtree: true };

        // Callback function to execute when mutations are observed
        var callback = function (mutationsList, observer) {
            for (var mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    var editLink = $('.tribe-community-notice-update .edit-event');
                    if (editLink.length > 0) {
                        console.log("Edit link found.");
                        updateEditLink();
                        // Optional: You might want to disconnect the observer after the link is found and updated
                        // observer.disconnect();
                    }
                }
            }
        };

        // Create an observer instance linked to the callback function
        var observer = new MutationObserver(callback);

        // Start observing the document body for configured mutations
        observer.observe(document.body, config);

        // Initial check in case the element is already present on page load
        if ($('.tribe-community-notice-update .edit-event').length > 0) {
            console.log("Edit link found on page load.");
            updateEditLink();
        }
    });






    //////FUNCTION TO ADD THE EFFECTS FOR THE SPONSOR LOGO UPLOAD 
    // Function to add sponsor logo input fields
    function addSponsorLogoInput() {
        var container = document.createElement('div');
        container.className = 'sponsor_logo_container';

        var newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'event_sponsors_logo[]';
        newInput.onchange = function () { previewImage(this, container); };
        newInput.style = 'margin-top: 10px;';

        container.appendChild(newInput);
        document.getElementById('event_sponsors').appendChild(container);
    }

    function previewImage(input, container) {
        var existingWarning = container.querySelector('.upload-warning');
        if (existingWarning) {
            existingWarning.remove();
        }

        if (input.files && input.files[0]) {
            var file = input.files[0];
            var allowedTypes = ['image/jpeg', 'image/png'];
            var maxSize = 500 * 1024; // 500KB in bytes

            var warningMessage = '';
            if (!allowedTypes.includes(file.type)) {
                warningMessage = 'Only JPEG and PNG files are allowed.';
            } else if (file.size > maxSize) {
                warningMessage = 'File size must be less than 500KB.';
            }

            if (warningMessage) {
                var warning = document.createElement('div');
                warning.textContent = warningMessage;
                warning.className = 'upload-warning';
                warning.style = 'color: red; margin-top: 10px;';

                container.appendChild(warning);
                input.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('sponsor_logo_preview');
                img.style = 'max-width: 100px; max-height: 100px; margin-top: 10px;';

                container.appendChild(img);

                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.textContent = 'Delete';
                removeButton.className = 'remove_sponsor_logo';
                removeButton.style = 'margin-left: 10px;';
                removeButton.onclick = function () {
                    container.remove();
                };

                container.appendChild(removeButton);
                input.style.display = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('add_sponsor_button').onclick = addSponsorLogoInput;

    jQuery(document).ready(function ($) {
        $('.remove_sponsor_logo').on('click', function () {
            var logoId = $(this).data('logo-id');
            var eventId = $(this).data('event-id');
            var nonce = '<?php echo wp_create_nonce("remove_sponsor_logo_nonce"); ?>'; // Correct PHP execution within JS

            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>', // Correct PHP execution within JS
                type: 'POST',
                data: {
                    action: 'remove_sponsor_logo',
                    nonce: nonce,
                    logo_id: logoId,
                    event_id: eventId,
                },
                success: function (response) {
                    if (response.success) {
                        // Logo removed, handle the UI here, such as removing the logo element
                        // Note: 'this' context may not refer to the clicked element inside the AJAX success callback
                        // Use '.bind(this)' or a different approach to maintain the 'this' context
                        $(this).closest('.sponsor_logo_container').remove();
                    } else {
                        // Error handling
                        alert('Failed to remove the logo.');
                    }
                }.bind(this) // Bind 'this' to function to maintain context
            });
        });
    });




///FUNCTION TO AUTO CLICK THE 

jQuery(document).ready(function($) {
    var intervalId;

    function checkAndClickRadioButton() {
        var ownCapacityRadio = $('#Tribe__Tickets_Plus__Commerce__WooCommerce__Main_own');

        // If the radio button exists and isn't already checked, click it
        if (ownCapacityRadio.length && !ownCapacityRadio.prop('checked')) {
            console.log('Clicking the own capacity radio button...');
            ownCapacityRadio.prop('checked', true).trigger('change');

                // Apply CSS with !important using jQuery
                $("#Tribe__Tickets_Plus__Commerce__WooCommerce__Main_unlimited").css("cssText", "margin-right: 25px !important;");
            // Check if the radio button is now checked
            if (ownCapacityRadio.prop('checked')) {
                console.log('Own capacity radio button is now checked.');
                clearInterval(intervalId); // Stop checking
            }
        }
    }

    // Run the check immediately in case the page loads with the form already visible
    checkAndClickRadioButton();

    // Listen for clicks on the form toggle button to start checking
    $('#ticket_form_toggle').on('click', function() {
        console.log('Toggle button clicked.');

        // Ensure we're not setting multiple intervals
        clearInterval(intervalId);

        // Start checking and clicking the radio button every 500 milliseconds
        intervalId = setInterval(checkAndClickRadioButton, 500);
    });
});









</script>


<style>



.edit-linked-post-link{
    display:none!important;
    visibility: hidden;
}

    .accordion-header {
        cursor: pointer;
        padding: 10px;
        background-color: #f0f0f0;
        border-top: 1px solid #ddd;
    }

    .accordion-content {
        display: none;
        /* Start with content hidden */
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .admin_agenda_accordion-header {
        cursor: pointer;
        background-color: black !important;
        color: #ffffff;
        padding: 18px;
        width: 100%;
        text-align: left;
        border-width: 0 !important;
        outline: none;
        transition: 0.4s;
        position: relative;
        font-size: 16px !important;
        font-weight: 500;
        margin-top: 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
        position: relative;
    }

    .admin_agenda_accordion-arrow {
        transition: transform 0.3s ease;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .admin_agenda_accordion-content {
        display: none;
        /* Content is initially hidden */
        padding: 10px;
        border-top: none;
        background-color: black !important;
        border-radius: 4px;
        margin-top: -5px;
    }

    /* Rotated class for arrow */
    .admin_agenda_rotated {
        transform: rotate(180deg);
    }

    .admin_agenda_agenda-items-wrapper {
        width: 100%;
        max-width: 600px !important;
    }




    .word-limit-exceeded {
        color: red;
    }

    .faq-item {
        background-color: black !important;
        color: #ffffff;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: 0.4s;
        position: relative;
        font-size: 16px !important;
        font-weight: 500;
        margin-top: 10px;
        border-radius: 4px;
    }


    /* Accordion toggle */
    .accordion::after {
        content: '';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
        border: solid #fff;
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 5px;
        transition: transform 0.4s ease-in-out;
    }

    /* Rotate arrow when accordion is active/open */
    .accordion.active::after {
        transform: translateY(-50%) rotate(-135deg);
    }

    /* Ensure that the container of the arrow doesn't clip the rotated arrow */
    .accordion {
        overflow: visible;
        position: relative;
        /* Position relative to allow absolute positioning of the pseudo-element */
    }

    .accordion-title span {
        font-size: 16px;
        text-transform: capitalize;
    }

    #add-faq {
        margin-top: 20px;
        padding: 7px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .accordion-content p {
        display: flex;
        gap: 10px;
        align-content: center;
        align-items: center;
    }

    .accordion-content label {
        margin-bottom: 0
    }

    .remove-faq {
        color: #E53D3D !important;
        border-radius: 6px;
        background: rgba(166, 28, 28, 0.20);
        padding: 4px 14px;
        font-size: 12px;
        text-decoration: none;
        height: fit-content;
        display: block;

    }

 label{
font-size:14px!important
    }
    .char-count {
        margin-right: 10px;
        color: #9d9d9d !important;
        float: right;
    }



    .accordion-content {
        margin-top: 20px;
        background-color: black
    }

    .accordion-content input,
    .accordion-content textarea {
        width: 100% !important
    }

    .event-section__form_link {
        margin-bottom: 20px;
        padding: 10px;
        display: flex;
        justify-content: center;
        /* Center the links */
        position: relative;
        /* For positioning the pseudo-elements */
        gap: 23px;

    }

    .event-section__form_link a {
        background-color: #3c3c3c;
        /* Lighter grey for default step */
        color: white;
        padding: 10px 15px;
        border-radius: 7px;
        /* Slightly rounded corners for the steps */
        text-decoration: none;
        position: relative;
        /* For the connecting lines */
        z-index: 1;
        /* To keep the links above the connecting lines */
        margin: 0 10px;
        /* Space between the links */
    }

    /* Connects the steps with lines */
    .event-section__form_link a:not(:first-child):before {
        content: '';
        position: absolute;
        top: 50%;
        left: -42px;
        /* Adjust as needed based on your spacing */
        width: 42px;
        /* This should be double the left offset to reach the previous button */
        height: 2px;
        /* Height of the connector line */
        background-color: #a2a2a2;
        z-index: 0;
        transform: translateY(-50%);
    }

    .event-section__form_link a.active,
    .event-section__form_link a.completed {
        background-color: #d5d5d5;
        /* Active/completed steps are green */
        color: black !important
    }

    /* Change the color of the line for completed steps */
    .event-section__form_link a.completed:before {
        background-color: #d5d5d5;
        /* Green color to indicate completion */
        color: black !important
    }

    /* Optional: Add transition for hover effect */
    .event-section__form_link a:hover {
        background-color: #d5d5d5;
        /* Darker green on hover */
        color: black !important
    }

    /* Special case for the first link if it needs to be active on load */
    .event-section__form_link a:first-child.active:before {
        background-color: #2C2C2C;
        /* Set this to the background color of the progress bar */
    }


    .tribe-ticket-control-wrap , .tribe-ticket-control-wrap__ctas , #ticket_type_options {
        display:none!important
    }

    #Tribe__Tickets_Plus__Commerce__WooCommerce__Main_ticket_global_stock:first-child {
    display: none !important;
}

#tribetickets .tribe-section-content {
    width: 100%;
}
#tribetickets label{
    font-weight: 500 !important;
    font-size: 15px;

}

#tribetickets .input_block .input_block , 
#tribetickets .input_block .ticket_form_right {
    margin-left: ih;
}
#post_title{
    font-size: 22px !important;
    font-weight: 700 !important;
    color: white !important;
    margin-bottom: 13px;
    padding: 0;
}
.quill-wrap{
    background: white;
    border-radius:5px!important
  
}
.quill-wrap span{
    color:black!important;
    background-color: inherit!important;
}
.ql-editor h1{
    font-size: 31px;
    font-weight: bold;
    line-height: 35px;
}
.ql-editor p{
    font-weight: 300;
    font-size: 17px;
}
.ql-editor h2{
    font-size: 23px;
}
.ql-editor p , .ql-editor h1 , .ql-editor h2{
    color:black!important 
}
#editor{
    color:black!important
}
.ql-toolbar.ql-snow , .ql-container.ql-snow {
    border: 0px!important
  
}
.ql-editor{
    min-height:150px!important;
    padding: 35px 15px;
}
#toolbar{
    background: #c6c6c6;
    border-radius: 5px 5px 0px 0px!important;
}
.ql-font {
    display:none!important
}
.ql-snow .ql-tooltip.ql-editing a.ql-action::after {
    border-right: 0px;
    content: 'Save';
    padding-right: 0px;
    color: black;
}
.req{
    float: left;
    font-size: 15px;
}
.tribe-section-content-label label{
    font-size:14px!important
}


.dark-mode input:-webkit-autofill, .dark-mode input:-webkit-autofill:focus, .dark-mode input:-webkit-autofill:hover, .dark-mode select:-webkit-autofill, .dark-mode select:-webkit-autofill:focus, .dark-mode select:-webkit-autofill:hover, .dark-mode textarea:-webkit-autofill, .dark-mode textarea:-webkit-autofill:focus, .dark-mode textarea:-webkit-autofill:hover {
    -webkit-text-fill-color: #000000;
}
</style>
