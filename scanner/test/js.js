<?php
$almondDelights = wc_get_product(629677);
$crunchyDelights = wc_get_product(629702);
$gooeyDelights = wc_get_product(629708);
$lemonDelights = wc_get_product(629713);
$madagascanDelights = wc_get_product(629717);
$nuttyDelights = wc_get_product(629721);
$passionDelights = wc_get_product(629725);
$pecanDelights = wc_get_product(629729);
$vanillaDelights = wc_get_product(629733);
$passionFruitDelights = wc_get_product(849142);
$caramelCupDelights = wc_get_product(849137);
$nuttyCrunchDelights = wc_get_product(849131);
$vanillaDeluDelights = wc_get_product(849122);
$velvetyDelights = wc_get_product(849148);


$almondDelightsStockStatus = $almondDelights->get_stock_status() == 'instock' ? 'In Stock' : 'Out of Stock';


?>
<script>
	let almondDelightsStockStatus = '<?php echo $almondDelightsStockStatus; ?>'


	let velvetyDelightsSalePrice = '<?php echo $velvetyDelights->get_sale_price() ? wc_price($velvetyDelights->get_sale_price()) : "N/A"; ?>';
	let velvetyDelightsRegularPrice = '<?php echo wc_price($velvetyDelights->get_regular_price()); ?>';
	
	let vanillaDeluDelightsSalePrice = '<?php echo $vanillaDeluDelights->get_sale_price() ? wc_price($vanillaDeluDelights->get_sale_price()) : "N/A"; ?>';
	let vanillaDeluDelightsRegularPrice = '<?php echo wc_price($vanillaDeluDelights->get_regular_price()); ?>';
	
	let nuttyCrunchDelightsSalePrice = '<?php echo $nuttyCrunchDelights->get_sale_price() ? wc_price($nuttyCrunchDelights->get_sale_price()) : "N/A"; ?>';
	let nuttyCrunchDelightsRegularPrice = '<?php echo wc_price($nuttyCrunchDelights->get_regular_price()); ?>';
	
	let caramelCupDelightsSalePrice = '<?php echo $caramelCupDelights->get_sale_price() ? wc_price($caramelCupDelights->get_sale_price()) : "N/A"; ?>';
	let caramelCupDelightsRegularPrice = '<?php echo wc_price($caramelCupDelights->get_regular_price()); ?>';
	
	let passionFruitDelightsSalePrice = '<?php echo $passionFruitDelights->get_sale_price() ? wc_price($passionFruitDelights->get_sale_price()) : "N/A"; ?>';
	let passionFruitDelightsRegularPrice = '<?php echo wc_price($passionFruitDelights->get_regular_price()); ?>';
	
	let almondDelightsSalePrice = '<?php echo $almondDelights->get_sale_price() ? wc_price($almondDelights->get_sale_price()) : "N/A"; ?>';
	let almondDelightsRegularPrice = '<?php echo wc_price($almondDelights->get_regular_price()); ?>';

	let crunchyDelightsSalePrice = '<?php echo $crunchyDelights->get_sale_price() ? wc_price($crunchyDelights->get_sale_price()) : "N/A"; ?>';
	let crunchyDelightsRegularPrice = '<?php echo wc_price($crunchyDelights->get_regular_price()); ?>';

	let gooeyDelightsSalePrice = '<?php echo $gooeyDelights->get_sale_price() ? wc_price($gooeyDelights->get_sale_price()) : "N/A"; ?>';
	let gooeyDelightsRegularPrice = '<?php echo wc_price($gooeyDelights->get_regular_price()); ?>';

	let lemonDelightsSalePrice = '<?php echo $lemonDelights->get_sale_price() ? wc_price($lemonDelights->get_sale_price()) : "N/A"; ?>';
	let lemonDelightsRegularPrice = '<?php echo wc_price($lemonDelights->get_regular_price()); ?>';

	let madagascanDelightsSalePrice = '<?php echo $madagascanDelights->get_sale_price() ? wc_price($madagascanDelights->get_sale_price()) : "N/A"; ?>';
	let madagascanDelightsRegularPrice = '<?php echo wc_price($madagascanDelights->get_regular_price()); ?>';

	let nuttyDelightsSalePrice = '<?php echo $nuttyDelights->get_sale_price() ? wc_price($nuttyDelights->get_sale_price()) : "N/A"; ?>';
	let nuttyDelightsRegularPrice = '<?php echo wc_price($nuttyDelights->get_regular_price()); ?>';

	let passionDelightsSalePrice = '<?php echo $passionDelights->get_sale_price() ? wc_price($passionDelights->get_sale_price()) : "N/A"; ?>';
	let passionDelightsRegularPrice = '<?php echo wc_price($passionDelights->get_regular_price()); ?>';

	let pecanDelightsSalePrice = '<?php echo $pecanDelights->get_sale_price() ? wc_price($pecanDelights->get_sale_price()) : "N/A"; ?>';
	let pecanDelightsRegularPrice = '<?php echo wc_price($pecanDelights->get_regular_price()); ?>';

	let vanillaDelightsSalePrice = '<?php echo $vanillaDelights->get_sale_price() ? wc_price($vanillaDelights->get_sale_price()) : "N/A"; ?>';
	let vanillaDelightsRegularPrice = '<?php echo wc_price($vanillaDelights->get_regular_price()); ?>';


	jQuery(document).ready(function($) {

			// Array of chocolate images
			const chocolateArray = [
					{ id: 'almond_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/NEW-ALMOND-TWIST-1-570x570.jpg' },
					{ id: 'crunchy_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/CRUNCHY-HAZELNUT-2-150x150.jpg' },
					{ id: 'gooey_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/GOOEY-CARAMEL-1-300x300.jpg' },
					{ id: 'lemon_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/NEW-LEMON-DROPS-1-300x300.jpg' },
					{ id: 'madagascan_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/MADAGASCAN-VANILLA-2-300x300.jpg' },
					{ id: 'nutty_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/NUTTY-CARAMEL-2-300x300.jpg' },
					{ id: 'passion_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/PASSION-FRUIT-1-300x300.jpg' },
					{ id: 'pecan_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/PECAN-PRALINE-2-300x300.jpg' },
					{ id: 'vanilla_choc', url: 'https://valentte.com/wp-content/uploads/2023/05/VANILLA-CARAMEL-1-300x300.jpg' },
					{ id: 'passion_fruit_choc', url: 'https://valentte.com/wp-content/uploads/2024/03/Passion-Fruit-Burst-1-min.jpg' },
					{ id: 'caramel_choc', url: 'https://valentte.com/wp-content/uploads/2024/03/Caramel-Cup-1-min.jpg' },
					{ id: 'nutty_crunch_choc', url: 'https://valentte.com/wp-content/uploads/2024/03/Nutty-Crunch-1-min.jpg' },
					{ id: 'vani_delu_choc', url: 'https://valentte.com/wp-content/uploads/2024/03/Vanilla-Deluxe-1-1-min.jpg' },
					{ id: 'velvety_choc', url: 'https://valentte.com/wp-content/uploads/2024/03/Velvety-Vanilla-Caramel-1-min.jpg' }
			];

			// Function to change chocolate image URL based on ID
			function changeChocolateImageById() {
					// Iterate through the chocolateArray and update the URL for each element
					chocolateArray.forEach(chocolate => {
							// Assuming there's an <img> tag within the element with id matching chocolate.id
							$('#' + chocolate.id + ' img').attr('src', chocolate.url);
							//console.log(`Changed image URL for chocolate with id ${chocolate.id} to ${chocolate.url}`);
					});
			}

			changeChocolateImageById()

			// Function to display chocolate information
			function displayChocolateInfo(chocolateSalePrice, chocolateRegularPrice, productId) {
				
					let salePriceText = $('<div>').html(chocolateSalePrice).text().replace('£', '');
					let salePrice = parseFloat(salePriceText)
				
					// Append regular price to the retail price element
					let retailDiv = $('#' + productId + ' .choc_retail_price').append(chocolateRegularPrice);

					// Append sale price to the sale price element
					let saleDiv = $('#' + productId + ' .choc_sale_price').append(chocolateSalePrice);

					// Check if sale price is not "NaN"
					if (!isNaN(salePrice)) {
							retailDiv.addClass('choc_onsale');
					} else {
							saleDiv.hide();
					}

			}
		
		// Function to put the correct variation in first
    function handleFirstProductOnThumbnail() {

        // Get the text of the main title
        const mainTitle = $('.summary .product_title.entry-title').text().toLowerCase();
        
        // Select all variation labels within the specified container
        const variationLabels = $('.summary .choc_variation-thumbnails.variation-thumbnails label');

        // Iterate through each variation label
        variationLabels.each(function(){
            // Reference to the current label
            const $this = $(this);

            // Extract the text of the variation title
            const variationTitle = $this.find('.choc_variation-title').text().toLowerCase();
            
            // Check if the variation title is included in the main title
            if(mainTitle.includes(`${variationTitle} chocolate delights`)) {

                // Add 'choc_selected' class to the current label
                $this.addClass('choc_selected');

                // Set the 'href' attribute of the 'a' tag to '#'
                $this.find('a').attr('href','#');

                // Move the label to the beginning of the container
                $this.prependTo('.summary .choc_variation-thumbnails.variation-thumbnails');
            }
        });
    }
		
		// Call the function to sort the first product
		handleFirstProductOnThumbnail()

			// Display information for artisan chocolates
			displayChocolateInfo(almondDelightsSalePrice, almondDelightsRegularPrice, 'almond_choc');

			// Display information for dad chocolates
			displayChocolateInfo(crunchyDelightsSalePrice, crunchyDelightsRegularPrice, 'crunchy_choc');

			// Display information for congratulations chocolates
			displayChocolateInfo(gooeyDelightsSalePrice, gooeyDelightsRegularPrice, 'gooey_choc');

			// Display information for Thank you chocolates
			displayChocolateInfo(lemonDelightsSalePrice, lemonDelightsRegularPrice, 'lemon_choc');

			// Display information for Birthday chocolates
			displayChocolateInfo(madagascanDelightsSalePrice, madagascanDelightsRegularPrice, 'madagascan_choc');

			// Display information for Nutty
			displayChocolateInfo(nuttyDelightsSalePrice, nuttyDelightsRegularPrice, 'nutty_choc');

			// Display information for Passion
			displayChocolateInfo(passionDelightsSalePrice, passionDelightsRegularPrice, 'passion_choc');

			// Display information for Pecan
			displayChocolateInfo(pecanDelightsSalePrice, pecanDelightsRegularPrice, 'pecan_choc');

			// Display information for Vanilla
			displayChocolateInfo(vanillaDelightsSalePrice, vanillaDelightsRegularPrice, 'vanilla_choc');
		
			// Display information for Passion Fruit
			displayChocolateInfo(passionFruitDelightsSalePrice, passionFruitDelightsRegularPrice, 'passion_fruit_choc');
	
			// Display information for Caramel Cup
			displayChocolateInfo(caramelCupDelightsSalePrice, caramelCupDelightsRegularPrice, 'caramel_choc');
	
			// Display information for Nutty Crunch
			displayChocolateInfo(nuttyCrunchDelightsSalePrice, nuttyCrunchDelightsRegularPrice, 'nutty_crunch_choc');
	
			// Display information for Vanilla Deluxe
			displayChocolateInfo(vanillaDeluDelightsSalePrice, vanillaDeluDelightsRegularPrice, 'vani_delu_choc');
	
			// Display information for Velvety Vanilla
			displayChocolateInfo(velvetyDelightsSalePrice, velvetyDelightsRegularPrice, 'velvety_choc');


	});
</script>