<?php
// Add shortcode for displaying the image gallery functionality
add_shortcode('organiser_image_gallery', 'organiser_image_gallery_shortcode');

function organiser_image_gallery_shortcode() {
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
 </div> 
 <div class="main-selector-image-upload-div">
                <div class="Organizer-image-upload-div">
                <p>Select Organizer Profile:</p><select id="organiser-selector" name='organiser'> </div>
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
                <p>Category Title:</p>
                <input type="text" id="category-name" name="category" placeholder="London 20-02-24" style="margin-bottom: 10px;" required>
                
                
                <div id="image-upload-function-btn-div">

                <input type="submit" id="upload-button" value="Upload">
                <span id="upload-count"></span>
                <button id="delete-all-button">Delete All Images</button>
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
        #image-gallery {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        #image-preview, #image-upload {
            flex-basis: 45%;
        }
        #drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            margin-bottom: 10px;
            cursor: pointer;
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
    top: 8px;
    right: 14px;
    background-color: #f44336;
    color: white;
    border: none;
    border-radius: 50%;
    width: 33px;
    height: 33px;
    cursor: pointer;
    font-weight: 700;
    padding: 0;
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
                            console.log(response); // Handle success response
                            location.reload();

                        },
                        error: function(error) {
                            console.log(error); // Handle error
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
            $result = wp_delete_term($category_id, 'tec_organizer_category');

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
        $category_images = get_term_meta($category_id, 'category_images', true); // get category images
        $category_images = explode(',', $category_images);

        // Display images
        if (!empty($category_images) ) {
            echo '<div class="category-images">';
            foreach($category_images  as $category_image){
                echo '<img src="' . esc_url($category_image) . '" alt="" />';
            }
            echo '</div>';
        } else {
            echo '<p>No images found in this category</p>';
        }

        // Display delete button for the category
        echo '<form id="delete-category-form" method="post">';
        echo '<input type="hidden" name="delete_category_id" value="' . esc_attr($category_id) . '" />';
        echo '<input type="submit" name="delete_category" value="Delete Category and Images" />';
        echo '</form>';

        // JavaScript functionality to handle category deletion and clear URL
        ?>
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







// Function to check the content of the image preview container
function toggleImagePreview() {
    var container = document.getElementById('image-preview-container');
    var header = document.querySelector('#image-preview h3');

    // Check if the container has any child nodes
    if (container.hasChildNodes()) {
        // If there is content, display the header
        header.style.display = 'block';
    } else {
        // If there is no content, hide the header
        header.style.display = 'none';
    }
}

// Call the function initially to set the correct display state
toggleImagePreview();


        </script>
        <?php

     
    } else {
        // If category_id is not provided, display categories with titles and thumbnails

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
                echo '<h2>' . esc_html($category_name) . '</h2>';
                echo '<h3>Organiser: ' . esc_html($cat_organiser) . '</h3>';
                echo '</div>'; // Close overlay div
            } else {
                echo '<p>No thumbnail available</p>';
            }
            echo '</a>';
            echo '</div>'; // Close category-item div
        }
        echo '</div>'; // Close category-gallery div
    }
    wp_reset_query();
    return ob_get_clean();
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
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

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
    



?>





<style>

.image-upload-div{
    background-color: rgb(26, 26, 26);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 33px;
    border-radius: 10px;
    width: fit-content;
}
    #image-upload{


    }
#image-gallery {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
    flex-direction: column;
    gap: 20px;
}
#drop-zone{
    position: relative;
    border: 2px dashed #dee2e6!important;
    text-align: center;
    border-radius: 17px;
    max-width: 800px;
    padding: 82px!important;
}
.fa-image {
    margin-top:-30px
}

#inputFile::-webkit-file-upload-button {
  visibility: hidden;
}


.drag-drop_text{
    margin:15px 0;
    font-weight: 600;
}

#drop-zone {
    /* Existing styles */
    border: 3px dashed #cccccc;
    /* Other styles */
}

#drop-zone:hover,
#drop-zone.dragover {
    border-color: #d3fa16 !important;
}

#drop-zone:hover .fa-image:before {
    color: #d3fa16;
}
#drop-zone:hover .drag-drop_text {
    color: #d3fa16!important;
}

.primary-icon {
    /* Other styles if any */
    transition: color 0.3s; /* Smooth transition for color change */
}

.Organizer-image-upload-div{
    display: flex;
    flex-direction: column;
    max-width: 400px;
    gap: 11px;

}
#upload-button{
    background-color:#d3fa16!important;
    color:black!important;
    border-radius: 3px!important;
    line-height: 1!important;
    margin: 10px!important;
    padding: 9px 12px!important;
    font-size: 13px!important;
}


#delete-all-button {
  background-color: #ff4747!important;
  color: white!important;
  border-radius: 3px!important;
    line-height: 1!important;
    margin: 10px!important;
    padding: 9px 12px!important;
    font-size: 13px!important;
}
.Organizer-image-upload-div p {
    margin-bottom:0!important;
    margin-top:10px!important
}

#image-preview h3{
display:none
}
</style>