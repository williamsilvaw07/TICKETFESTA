<?php
// Add shortcode for displaying the image gallery functionality
add_shortcode('organiser_image_gallery', 'organiser_image_gallery_shortcode');

function organiser_image_gallery_shortcode() {
    $total_mb = 3;
    $account_mb_used = get_user_meta( get_current_user_id(), 'total_upload', true );
    $account_mb_used = $account_mb_used ? $account_mb_used : 0;
    $usage_percentage = ($account_mb_used / $total_mb) * 100;
    $usage_percentage_formatted = number_format($usage_percentage, 2); // Format to 2 decimal places if needed
    $default_organizer = get_default_organizer();
    ob_start(); ?>

    <!-- HTML structure for the image gallery -->
    <h2 class="tribe-community-events-list-title">Upload Images</h2>
    <div id="image-gallery">
     
     
        <div id="image-upload">
            <div class="image-upload-div">
                <div id="drop-zone">
                    <span class="primary-icon fas fa-image fa-stack-2x"></span>
                    <p class="drag-drop_text">  Drag & drop images here or click to select images.</p>
         
                    <form id="image-upload-form" enctype="multipart/form-data">
                        <input type="file" id="file-input" name="files[]" multiple>
                </div>
            </div>
            <p class='max-upload'> Account Storage Plan Maximum Upload Limit 3MB </p>
            <?php
  // HTML markup for displaying categories with titles and thumbnails
  echo "<div style='max-width: 500px; width: 100%;'> <!-- Container div for max-width and responsiveness -->
  <div class='progress' style='height: 20px; margin-top: 20px;'>
      <div class='progress-bar' role='progressbar' 
          style='width: {$usage_percentage_formatted}%; padding: 0 10px;' 
          aria-valuenow='{$account_mb_used}' 
          aria-valuemin='0' 
          aria-valuemax='{$total_mb}'>
        Used {$account_mb_used}/3 MB
      </div>
  </div>
</div>";

?>
            
            <p class='upload_limit' style='color:red!important; display: none; '> Account Maximum Upload Limit Reached </p>
            <?php if($default_organizer) {?>
                <p class='default-organizer'> Organizer : <?php echo $default_organizer; ?></p>
            <?php } ?>
        </div> 
        <div class="main-selector-image-upload-div">
            <div class="Organizer-image-upload-div">
                <p class="select-organizer">Select Organizer Profile:</p>
                <select id="organiser-selector" name='organiser'> </div>
                    <?php
                    // Get list of organizers created by the current user
                    $organisers = get_posts(array(
                        'post_type' => 'tribe_organizer', // Assuming 'organiser' is the custom post type for organizers
                        'author' => get_current_user_id(), // Retrieve organizers only for the current user
                        'posts_per_page' => -1
                    ));

                    // Display options for selecting organizer
                    foreach ($organisers as $organiser) {
                        echo '<option value="' . esc_attr($organiser->ID) . '">' . esc_html($organiser->post_title) . '</option>';
                    }
                    ?>
                </select>
                <p>Gallery Title:</p>
                <input type="text" id="category-name" name="category" placeholder="E.g London Tiger Tiger 20/03/23" style="margin-bottom: 10px;" required>
                
                
                <div id="image-upload-function-btn-div">

                <input type="submit" id="upload-button" value="Upload">
                <span id="upload-count"></span>
                <button id="delete-all-button" class="delete-all-button">Delete All Images</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    <div id="image-preview">
        <h3>Image Preview</h3>
        <div id="image-preview-container"></div>
    </div>
    <!-- Modal for showing upload status -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="success-modal-message"></p>
                    <p id="error-modal-message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline CSS for styling -->
    <style>
        .select-organizer, #organiser-selector{
            height: 1px!important;
            visibility: hidden;
        }
        
        #image-preview, #image-upload {
            flex-basis: 45%;
        }
       
        #upload-count{
            font-size:13px!important
        }
        .thumbnail-container {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
        .delete-button {
            position: absolute;
    top: 2px;
    right: 5px;
    background-color: #f44336;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    font-weight: 700;
    padding: 0;
    line-height: 25px;
        }

    
        
    </style>

    <!-- Inline JavaScript for functionality -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropZone = document.getElementById('drop-zone');
            var fileInput = document.getElementById('file-input');
            var imagePreviewContainer = document.getElementById('image-preview-container');
            var categoryNameInput = document.getElementById('category-name');
            var organiserSelector = document.getElementById('organiser-selector');
            var uploadCountSpan = document.getElementById('upload-count');
            var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));

            // Event listener for dropping files
            dropZone.ondrop = function(event) {
                event.preventDefault();
                fileInput.files = event.dataTransfer.files;
                previewImages(fileInput.files);
            };

            // Event listener for dragover
            dropZone.ondragover = function(event) {
                event.preventDefault();
            };

            // Event listener for file input change
            fileInput.onchange = function() {
                previewImages(fileInput.files);
            };

            // Function to preview uploaded images
            function previewImages(files) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (!file.type.startsWith('image/')) {
                        continue;
                    }
                    var imgContainer = document.createElement("div");
                    imgContainer.classList.add("thumbnail-container");
                    var img = document.createElement("img");
                    img.classList.add("preview-image");
                    img.file = file;
                    imgContainer.appendChild(img);
                    var reader = new FileReader();
                    reader.onload = (function(aImg) {
                        return function(e) {
                            aImg.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);

                    // Add delete button
                    var deleteButton = document.createElement("button");
                    deleteButton.classList.add("delete-button");
                    deleteButton.innerHTML = "&times;";
                    // deleteButton.onclick = function() {
                    //     imgContainer.remove();
                    // };
                    imgContainer.appendChild(deleteButton);

                    imagePreviewContainer.appendChild(imgContainer);

                    // delete images 
                    var deleteButtons = document.querySelectorAll(".delete-button");

                    // Iterate over each delete button
                    deleteButtons.forEach(function(button) {
                        // Add click event listener to each delete button
                        button.addEventListener("click", function() {
                            // Get the parent container of the delete button which is the image container
                            var imgContainer = this.parentNode;
                            // Remove the image container
                            imgContainer.remove();
                            updateFileList()
                        });
                    });

                    // Function to update file input's files list
                    function updateFileList() {
                        // Get all image containers
                        var imgContainers = document.querySelectorAll(".thumbnail-container");
                        // Create an array to hold File objects
                        var fileList = [];
                        // Iterate over each image container
                        imgContainers.forEach(function(container) {
                            // Get the file URL from the image source
                            var fileUrl = container.querySelector("img").src;
                            // Convert the file URL to a Blob object
                            fetch(fileUrl)
                                .then(response => response.blob())
                                .then(blob => {
                                    // Create a File object from the Blob
                                    var file = new File([blob], "image.jpg");
                                    // Push the File object to the array
                                    fileList.push(file);
                                    // If all files have been added to the array
                                    if (fileList.length === imgContainers.length) {
                                        // Create a new FileList object with the array of files
                                        var newFileList = new DataTransfer();
                                        fileList.forEach(file => newFileList.items.add(file));
                                        // Set the new FileList object to the file input
                                        fileInput.files = newFileList.files;
                                    }
                                });
                        });
                    }

                }
                // Update upload count
                uploadCountSpan.textContent = 'Uploaded Images: ' + imagePreviewContainer.children.length;
            }

            jQuery(document).ready(function($) {
                $('#image-upload-form').on('submit', function(event) {
                    event.preventDefault();
                    var formData = new FormData(this);
                    formData.append('action', 'upload_images_cat');
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>', 
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.success){
                                console.log('success',response); // Handle success response
                                var targetUrl = "https://ticketfesta.co.uk/organiser-gallery/";
                                window.location.href = targetUrl;

                            }else{
                                $('.upload_limit').show();
                                console.log('error',response); 
                            }
                        },
                        error: function(error) {
                            console.log('error',error); // Handle error
                        }
                    });
                });
            });

            // Event listener for upload button click
            // document.getElementById('upload-button').onclick = function() {
            //     var formData = new FormData(this);
            //     var files = [];
            //     var imgContainers = document.querySelectorAll(".thumbnail-container");

            //     if (imgContainers.length === 0) {
            //         showErrorModal('Please select at least one image.');
            //         return;
            //     }
            //     imgContainers.forEach(function(container) {
            //             files.push(container.querySelector("img").src);
            //     });

            //     // for (var i = 0; i < files.length; i++) {
            //     //     formData.append('images[]', files[i]);
            //     // }
                // var categoryName = categoryNameInput.value;
                // if (categoryName.trim() === '') {
                //     showErrorModal('Please enter a category name.');
                //     return;
                // }

            // Function to show error modal
            function showErrorModal(message) {
                document.getElementById('error-modal-message').textContent = message;
                uploadModal.show();
            }

            // Function to show success modal
            function showSuccessModal(message) {
                document.getElementById('success-modal-message').textContent = message;
                uploadModal.show();
            }
        });







    </script>

    <?php
    return ob_get_clean();
}

// Add shortcode for displaying categories with titles and thumbnails
add_shortcode('category_image_gallery', 'category_image_gallery_shortcode');

function category_image_gallery_shortcode($atts) {
    ob_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_category_id"])) {
        $category_id = $_POST["delete_category_id"];

        if (is_numeric($category_id)) {
            require_once('wp-load.php');

            $category_images = get_term_meta($category_id, 'category_images', true);
            $category_images = explode(',', $category_images);
            foreach($category_images as $category_image){
                $media_id = attachment_url_to_postid($category_image);
                wp_delete_attachment($media_id, true); 
            }

            $result = wp_delete_term($category_id, 'tec_organizer_category');
            recalculate_user_memory_used();
            if (is_wp_error($result)) {
                echo "Error: " . $result->get_error_message();
            } else { ?>
            <script>
                window.history.replaceState({}, document.title, window.location.pathname);
            </script>

            <?php
            }
        } else {
            echo "Invalid category ID!";
        }
    }
    // Get current user ID
    $current_user_id = get_current_user_id();

    // Check if category_id parameter is provided
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
    // If category_id is provided, display images in the specified category
    if ($category_id && !isset($_POST["delete_category_id"])) {
        $term               = get_term_by('id', $category_id, 'tec_organizer_category');
        $category_images    = get_term_meta($category_id, 'category_images', true); // get category images
        $category_images    = explode(',', $category_images);
        $cat_organiser      = get_term_meta($category_id, 'category_organiser', true);
        $cat_organiser      = get_post($cat_organiser);

        if($current_user_id  != $cat_organiser->post_author){
            echo wc_get_account_endpoint_url('dashboard');
            wp_redirect(wc_get_account_endpoint_url('dashboard'));
            exit;
        }
        // echo "<pre>";
        // var_dump('user_id: ', $current_user_id);
        // var_dump('cat_organiser: ', $cat_organiser->post_author);
        // echo "</pre>";
        // Display images
        echo "<div class='category_main'>";
        echo "<div class='category_main_title'>";
        echo "<div class='tribe-community-events-list-title category'> $term->name </div>";
        echo "<div class='organizer'>Organizer: $cat_organiser->post_title</div>";
        echo "</div>";
       
          // Display delete button for the category
          echo '<form id="delete-category-form" method="post">';
          echo '<input type="hidden" name="delete_category_id" value="' . esc_attr($category_id) . '" />';
          echo '<input type="submit" name="delete_category" class="delete-all-button" value="Delete Gallery" />';
          echo '</form>';
          echo "</div>";
        if (!empty($category_images) ) {
            echo '<div class="category-images">';
            foreach($category_images  as $category_image){
                echo '<div class="img-container">';
                echo '<img src="' . esc_url($category_image) . '" alt="" />';
                echo '<div class="meta">';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No images found in this category</p>';
        }

      
        // JavaScript functionality to handle category deletion and clear URL
        ?>
        <style>
            .hide_gallery_upper_section{
                display: none;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('delete-category-form').addEventListener('submit', function(event) {
                    if (!confirm('Are you sure you want to delete this category and its images?')) {
                        event.preventDefault();
                    } 
                });
            });

            var dropZone = document.getElementById('drop-zone');

            // Add event listeners for drag & drop functionality
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault(); // This is necessary to allow a drop event
                this.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', function(e) {
                this.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', function(e) {
                this.classList.remove('dragover');

            });

        </script>
        <?php

     
    } else {
        // If category_id is not provided, display categories with titles and thumbnails

        $account_mb_used = get_user_meta( $current_user_id, 'total_upload', true );
        $account_mb_used = $account_mb_used ? $account_mb_used : 0;
        // Query categories created by the current user
        $categories = get_categories(array(
            'taxonomy' => 'tec_organizer_category',
            'hide_empty' => false,
            'meta_query' => array(
                array(
                    'key' => 'category_owner_id',
                    'value' => $current_user_id,
                    'compare' => '='
                )
            )
        ));

        // Check if the user has created any categories
        if (empty($categories)) {
            echo '<p>No categories found.</p>';
            return ob_get_clean();
        }

        // HTML markup for displaying categories with titles and thumbnails
        echo "<div style='max-width: 500px; width: 100%;'> <!-- Container div for max-width and responsiveness -->
        <p class='account_storage'>Account Storage</p>
        <div class='progress' style='height: 20px; margin-top: 20px;'>
            <div class='progress-bar' role='progressbar' 
                style='width: {$usage_percentage_formatted}%; padding: 0 10px;' 
                aria-valuenow='{$account_mb_used}' 
                aria-valuemin='0' 
                aria-valuemax='{$total_mb}'>
              Used {$account_mb_used}/3 MB
            </div>
        </div>
      </div>";
        echo '<div class="category-gallery">';
    
        foreach ($categories as $category) {
            $category_id = $category->term_id;
            $category_name = $category->name;
            $category_link = add_query_arg('category_id', $category_id, get_permalink());
            $category_images = get_term_meta($category_id, 'category_images', true);
            $cat_organiser = get_term_meta($category_id, 'category_organiser', true);
            $cat_organiser = get_post($cat_organiser)->post_title; 
            $category_images = explode(',', $category_images);
        
            echo '<div class="category-item">';
            echo '<a href="' . esc_url($category_link) . '">';
            if (!empty($category_images)) {
                $attachment_id = attachment_url_to_postid($category_images[0]);
                $attachment_src = wp_get_attachment_image_src($attachment_id, 'large')[0];
                echo '<img src="' . esc_url($attachment_src) . '" alt="' . esc_attr($category_name) . '" />';
                echo '<div class="overlay">';
                echo '<h4>' . esc_html($category_name) . '</h4>';
                echo '<h5>Organiser: ' . esc_html($cat_organiser) . '</h5>';
                echo '</div>'; // Close overlay div
            } else {
                echo '<p>No thumbnail available</p>';
            }
            echo '</a>';
            echo '</div>'; // Close category-item div
        }
        echo '</span>'; // Close category-gallery div
    }
    wp_reset_query();
    return ob_get_clean();
}

function get_default_organizer(){
    $customer_id = get_current_user_id();
    $organizer_id =  get_user_meta($customer_id, '_tribe_organizer_id', true);
    return $organizer_id ? get_the_title($organizer_id) : set_default_organizer($customer_id);
}

function set_default_organizer($customer_id){
    $organisers = get_posts(array(
        'post_type' => 'tribe_organizer', // Assuming 'organiser' is the custom post type for organizers
        'author' => $customer_id, // Retrieve organizers only for the current user
        'posts_per_page' => -1
    ));
    update_user_meta($customer_id, '_tribe_organizer_id', $organisers[0]->ID);
    return get_the_title($organisers[0]->ID);
}
function register_as_media($url){
    // require_once("wp-load.php");

    // URL of the file to register
    $file_url = $url;

    // Get the file name from the URL
    $file_name = basename($file_url);

    // Fetch the file content
    $file_content = file_get_contents($file_url);

    // Check if file content was retrieved successfully
    if ($file_content === false) {
        // Handle error appropriately
        echo "Error fetching file.";
    } else {
        // Get the uploads directory
        $upload_dir = wp_upload_dir();

        // Set the file path for the new file
        $file_path = $upload_dir['path'] . '/' . $file_name;

        // Save the file to the uploads directory
        $save_file = file_put_contents($file_path, $file_content);

        // Check if file was saved successfully
        if ($save_file !== false) {
            // Set the post title
            $post_title = $file_name;

            // Set the post content (optional)
            $post_content = '';

            // Set the post status
            $post_status = 'inherit';

            // Set the post mime type based on the file extension
            $file_type = wp_check_filetype($file_name, null);
            $post_mime_type = $file_type['type'];

            // Prepare attachment data
            $attachment = array(
                'post_title'     => $post_title,
                'post_content'   => $post_content,
                'post_status'    => $post_status,
                'post_mime_type' => $post_mime_type
            );

            // Insert the attachment
            $attachment_id = wp_insert_attachment($attachment, $file_path);

            // Check for errors
            if (!is_wp_error($attachment_id)) {
                // Generate attachment metadata and update the attachment
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                wp_update_attachment_metadata($attachment_id, $attachment_data);
                return wp_get_attachment_image_src($attachment_id, 'full')[0];

            } else {
                // Handle error appropriately
                echo "Error registering media file: " . $attachment_id->get_error_message();
            }
        } else {
            // Handle error appropriately
            echo "Error saving file.";
        }
    }
}



function custom_category_fields() {
    ?>
    <div class="form-field">
        <label for="category-images"><?php _e('Category Images', 'textdomain'); ?></label>
        <input type="hidden" name="category_images" id="category-images" class="category-images" value="">
        <input type="button" id="category-images-button" class="button" value="<?php _e( 'Upload Images', 'textdomain' ); ?>" />
        <div id="category-images-preview"></div>
    </div>
    <div class="form-field">
        <label for="category-organiser"><?php _e('Category Organiser', 'textdomain'); ?></label>
        <select  name="category_organiser" id="category-organiser" class="category-organiser" value="">
            <?php
            // Query 'tribe_organizer' posts
            $organizer_args = array(
                'post_type' => 'tribe_organizer',
                'posts_per_page' => -1,
            );
            $organizer_posts = get_posts($organizer_args);

            // Loop through 'tribe_organizer' posts and display as options
            foreach ($organizer_posts as $organizer_post) {
                echo '<option value="' . esc_attr($organizer_post->ID) . '">' . esc_html($organizer_post->post_title) . '</option>';
            }
            ?>
        </select>
    </div>
    <?php
}
add_action('tec_organizer_category_add_form_fields', 'custom_category_fields', 10, 2);

// Edit custom fields of category
function edit_custom_category_fields($term) {
    $category_images = get_term_meta($term->term_id, 'category_images', true);
    $category_organiser = get_term_meta($term->term_id, 'category_organiser', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category-images"><?php _e('Category Images', 'textdomain'); ?></label></th>
        <td>
            <input type="hidden" name="category_images" id="category-images" class="category-images" value="<?php echo esc_attr($category_images); ?>">
            <input type="button" id="category-images-button" class="button" value="<?php _e( 'Upload Images', 'textdomain' ); ?>" />
            <div id="category-images-preview">
                <?php
                if (!empty($category_images)) {
                    $images = explode(',', $category_images);
                    foreach ($images as $image) {
                        echo '<img src="' . esc_url($image) . '" style="max-width: 100px; margin-right: 10px;" />';
                    }
                }
                ?>
            </div>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category-organiser"><?php _e('Category Organiser', 'textdomain'); ?></label></th>
        <td>
        <select  name="category_organiser" id="category-organiser" class="category-organiser" value="">
            <?php
            // Query 'tribe_organizer' posts
            $organizer_args = array(
                'post_type' => 'tribe_organizer',
                'posts_per_page' => -1,
            );
            $organizer_posts = get_posts($organizer_args);

            // Loop through 'tribe_organizer' posts and display as options
            foreach ($organizer_posts as $organizer_post) {
                echo '<option value="' . esc_attr($organizer_post->ID)  . '"';
                if(  esc_attr($organizer_post->ID) == $category_organiser) echo 'selected';
                echo '>' . esc_html($organizer_post->post_title) . '</option>';
            }
            ?>
        </select>
        </td>
    </tr>
    <?php
}
add_action('tec_organizer_category_edit_form_fields', 'edit_custom_category_fields', 10, 2);

// Save custom fields of category
function save_custom_category_fields($term_id) {
    if (isset($_POST['category_images'])) {
        update_term_meta($term_id, 'category_images', sanitize_text_field($_POST['category_images']));
    }
    if (isset($_POST['category_organiser'])) {
        update_term_meta($term_id, 'category_organiser', sanitize_text_field($_POST['category_organiser']));
    }
}
add_action('edited_tec_organizer_category', 'save_custom_category_fields', 10, 2);
add_action('create_tec_organizer_category', 'save_custom_category_fields', 10, 2);

// add relation with organiser to tec_organizer_category



function enqueue_media_uploader($hook) {
    if ('term.php' === $hook && isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'tec_organizer_category' ||
        'edit-tags.php' === $hook && isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'tec_organizer_category') {
        wp_enqueue_media();
        wp_enqueue_script('category-media-uploader', get_stylesheet_directory_uri() . '/js/admin-custom-cat.js', array('jquery'), null, true);
    }

    if ('tribe_events_page_tickets-orders' === $hook) {

        $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : ''; // Replace with the actual event ID
        $orders = get_orders_by_event_id($event_id);
        $site_fees = get_site_fees_total_order_ids($orders);
        wp_enqueue_script('admin-order-js', get_stylesheet_directory_uri() . '/js/admin-order.js', array('jquery'), null, true);
        wp_localize_script('admin-order-js', 'order_data', array(
            'site_fees' => $site_fees
        ));
    }
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');


// returns site fees for order id array
function get_site_fees_total_order_ids($order_ids = []){
    $total_fee = 0;
    foreach($order_ids as $order_id){
        $order = wc_get_order($order_id);
        $fees = $order->get_fees();
        if (!empty($fees)) {
            foreach ($fees as $fee) {
                $total_fee += (float)$fee->get_total();
            }
        }
    } 
    return  $total_fee;  
}
// Get all orders by event ID
function get_orders_by_event_id( $meta_value) {
    global $wpdb;
    $meta_key='_community_tickets_order_fees';

    // Prefix for WordPress database tables
    $prefix = $wpdb->prefix;


    $query = $wpdb->prepare("
    SELECT p.ID
    FROM {$prefix}posts p
    INNER JOIN {$prefix}postmeta pm ON p.ID = pm.post_id
    WHERE pm.meta_key = %s 
    AND pm.meta_value LIKE %s
    AND p.post_type = 'shop_order'
    AND p.post_status = %s", $meta_key, '%' . $meta_value . '%', 'wc-completed');

    // Execute the query
    $order_ids = $wpdb->get_col($query);
    // Return the order IDs
    return $order_ids;

}
// Hooking the handler function to both logged-in and non-logged-in users
add_action('wp_ajax_upload_images_cat', 'upload_images_cat');
add_action('wp_ajax_nopriv_upload_images_cat', 'upload_images_cat');

function upload_images_cat() {
    // Check if files were received
    if (isset($_FILES['files'])) {
        $files = $_FILES['files'];
        $category = $_POST['category']; 
        $organiser = $_POST['organiser'];
        $attachments = array();
        $upload_dir = wp_upload_dir();
        $success = false;
        $messages = '';
        if(!tec_check_account_upload_limit($organiser, $files)){
            wp_send_json_error('Image upload limit reached');
        }
        if ( ! empty( $upload_dir['basedir'] ) ) {

            $user_dirname = $upload_dir['basedir'].'/organiser-images/';
            $user_baseurl = $upload_dir['baseurl'].'/organiser-images/';
            $image_urls = [];

            if ( ! file_exists( $user_dirname ) ) {
                wp_mkdir_p( $user_dirname );
            }
            foreach ($files['name'] as $index => $filename) {
                $filename = wp_unique_filename( $user_dirname, $_FILES['files']['name'][$index] );
                $success = move_uploaded_file( $_FILES['files']['tmp_name'][$index], $user_dirname .''. $filename);
                $image_url = $user_baseurl .''. $filename;
                $image_urls[] = register_as_media($image_url);
            }

            if( !empty( $success ) ){
                $success = true;
            }else{
                $success = false;
            }
            $messages = array( 'success' => $success, 'image_url' => $image_urls );
            create_tec_organizer_category_with_images($category, $image_urls, $organiser);
            wp_send_json( $messages );
        }
       

    } else {
        // No files received
        wp_send_json_error('No images received');
    }
    exit();
}

function create_tec_organizer_category_with_images($category_name, $image_urls, $organiser) {

    $user_id = get_current_user_id();
    $category_slug = strtolower(preg_replace('/[^a-z0-9]/', '', $category_name)) . '_' . $user_id;
    $term = get_term_by('slug', $category_slug, 'tec_organizer_category');
    $term_id = '';
    if ( ! $term ) {
        $args = array(
            'slug' => $category_slug,
        );
      $term = wp_insert_term( $category_name, 'tec_organizer_category', $args );
      $term_id = $term['term_id'];
    } else {
        $term_id = $term->term_id;
    }
    update_term_meta( $term_id, 'category_owner_id', $user_id );

    if ( $term_id ) {
        $sanitized_urls = array_map( 'esc_url', $image_urls ); 
        update_term_meta( $term_id, 'category_images', implode(',', $sanitized_urls) );
    }
    if ( $organiser ) {
        update_term_meta( $term_id, 'category_organiser', sanitize_text_field($organiser) );
    }
}

// this function recalculate user memory used
function recalculate_user_memory_used(){
    $current_user_id = get_current_user_id();
    $terms = get_categories(array(
        'taxonomy' => 'tec_organizer_category',
        'hide_empty' => false,
        'meta_query' => array(
            array(
                'key' => 'category_owner_id',
                'value' => $current_user_id                ,
                'compare' => '='
            )
        )
    ));

    $category_images = '';
    $total_size_used_kb = 0;
    foreach($terms as $term ){
        $term_id   = $term->term_id;
        $images    = get_term_meta($term_id, 'category_images', true); // get category images
        $category_images .= $images . ',';
    }
    $category_images = explode(',', $category_images);
    foreach($category_images as $category_image){
        if($category_image !== ''){
            $headers = get_headers( $category_image, 1 );
            if ( isset( $headers['Content-Length'] ) ) {
                $filesize_bytes = (int) $headers['Content-Length'];
                $filesize_mb = round( ( $filesize_bytes / 1024)  , 2 ); // Convert to KB
                $total_size_used_kb += $filesize_mb;
            }
        }
    }
    $limit_check = round( ($total_size_used_kb / 1024) , 2);
    update_user_meta( $current_user_id, 'total_upload', $limit_check );
}
function tec_check_account_upload_limit($organizer_id, $files){
    $sizes = $files['size'];
    $current_user_id = get_current_user_id();
    $terms = get_categories(array(
        'taxonomy' => 'tec_organizer_category',
        'hide_empty' => false,
        'meta_query' => array(
            array(
                'key' => 'category_owner_id',
                'value' => $current_user_id                ,
                'compare' => '='
            )
        )
    ));
    $request_upload_kb = 0;

    foreach($sizes as  $size){
        $request_upload_kb = $request_upload_kb + ($size / 1024);
    }
    
    $category_images = '';
    $total_size_used_kb = 0;
    foreach($terms as $term ){
        $term_id   = $term->term_id;
        $images    = get_term_meta($term_id, 'category_images', true); // get category images
        $category_images .= $images . ',';
    }
    $category_images = explode(',', $category_images);
    foreach($category_images as $category_image){
        if($category_image !== ''){
            $headers = get_headers( $category_image, 1 );
            if ( isset( $headers['Content-Length'] ) ) {
                $filesize_bytes = (int) $headers['Content-Length'];
                $filesize_mb = round( ( $filesize_bytes / 1024)  , 2 ); // Convert to KB
                $total_size_used_kb += $filesize_mb;
            }
        }
    }
    $total_size_used_kb = $total_size_used_kb + $request_upload_kb;
    $limit_check = round( ($total_size_used_kb / 1024) , 2);
    if($limit_check < 3){
        update_user_meta( $current_user_id, 'total_upload', $limit_check );
        return true;
    }else{

        return false;
    }
    return false;
}





