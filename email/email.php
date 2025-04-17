<?php

    $features = array();
    if($email_data['IsAirconditioning']){
        $features[] = get_field('email_air_conditioning', 'options');
    }
    if($email_data['IsAutomatic']){
        $features[] = get_field('email_automatic_transmission', 'options');
    }
    if($email_data['IsManual']){
        $features[] = get_field('email_manual_transmission', 'options');
    }

    $email_data['AgeRange'] = $email_data['Age'];


            if ($email_data['Age']>=30 && $email_data['Age']<=65)  {

          
            	$email_data['AgeRange'] ='30-65';
        	} ;
        	
            $flight_details = '';
        	if(!empty($email_data['flight_airline']) || !empty($email_data['flight_no']) ){

        		$flight_details = ' ('.$email_data['flight_airline'].' '.$email_data['flight_no'].')';

        	}
?>
<!DOCTYPE html>
<html lang="en" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: sans-serif;color: #010101;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;font-size: 10px;-webkit-tap-highlight-color: rgba(0,0,0,0);line-height: 1.15;">
<head style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<meta charset="UTF-8" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<title style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/6.0.0/normalize.min.css" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQRangeSlider/5.7.2/css/classic.min.css" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<link rel="stylesheet" href="css/style.css" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
	<!-- <link rel="stylesheet" href="css/style-media.css" /> -->
	
</head>
<body class="email" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;color: #333;margin: 0;font-size: 14px;line-height: 1.42857143;background-color: #f4f6f7;background: white;">
	<header class="email-main-header email-container-fluid" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;display: block;padding-top: 23px;margin-bottom: 40px;background: url(<?php echo plugins_url('email/img/email_header_img.png' , dirname(__FILE__)) ?>);">
		<div class="main-header__wrap email-container email-main-header-flex" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;display: flex;justify-content: space-between;align-items: left;flex-direction: column;max-width: 600px;margin-left: auto;margin-right: auto;position: relative;">
		<!-- <img src="img/round_shape2.png" alt="" class="email-main-header__rounded-shape" /> -->
			<div class="email-main-header__logo-wrap" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;background-color: white;padding-left: 17px;padding-right: 21px;padding-top: 9px;border-top-right-radius: 5px;border-top-left-radius: 5px;margin-top: 25px;padding-bottom: 13px;position: relative;z-index: 10;">
				<img src="<?php echo plugins_url( 'email/img/icon-logo.png' , dirname(__FILE__)) ?>" alt="" class="email-main-header__logo" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;border: 0;vertical-align: middle;page-break-inside: avoid;border-style: none;margin-bottom: -10px;width: 183px;height: 51px;max-width: 100%!important;">
			</div>
		<a href="#" class="email-main-header__link" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #337ab7;background-color: transparent;text-decoration: underline;-webkit-text-decoration-skip: objects;display: none;">View in browser</a>	
		</div>
		
	</header>

	<div class="email-container" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;max-width: 600px;margin-left: auto;margin-right: auto;position: relative;">
		<div class="email-info" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
			<h1 class="email-info__recipement" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: inherit;color: #e8503e;margin: .67em 0;font-size: 24px;font-weight: 500;line-height: 1.1;margin-top: 20px;margin-bottom: 10px;"><?php echo get_field('email_dear_mr', 'options'); ?> <?php echo $email_data['first_name'] . ' ' . $email_data['last_name'].' ( '.$email_data['phone'].' '.$email_data['email'].' )' ?>,</h1>

			<div class="email-info__thanks additional_text" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-top: 33px;padding-left: 2px;">
				<p class="additional_text__thanks" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;"><?php echo get_field('thank_you_for', 'options'); ?></p>
				<p class="additional_text__request" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-top: 4px;"><?php echo get_field('email_reservation_request', 'options'); ?></p>
			</div> 

			<div class="email-info__reservation-details email-details-table" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;border: 1px solid #d4dadd;margin-top: 34px;padding-bottom: 70px;overflow: auto;">
				<h1 class="email-details-table__title" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: inherit;color: #000000;margin: 0;font-size: 18px;font-weight: 500;line-height: 1.1;margin-top: 0px;margin-bottom: 10px;text-align: center;background-color: #d4dadd;padding-top: 5px;padding-bottom: 10px;"><?php echo get_field('email_reservation_details', 'options'); ?></h1>
				<div class="email-details-table__content table-content clearfix" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;display: block;-webkit-flex-direction: row;flex-direction: row;align-items: flex-start;justify-content: space-between;padding-left: 21px;padding-top: 23px;padding-right: 21px;padding-bottom: 22px;">
					<div class="table-content__block" style="font-size: 13px;float: left;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;min-width:49%;max-width:49%;display: inline-block;vertical-align: top;">
						<p class="table-content__block--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_reservation_number', 'options'); ?> <span class="table-content__block--line-distance1" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 14px;font-weight: 600;"><?php echo $email_data['order_id'] ?></span></p>
						<p class="table-content__block--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_number_of_days', 'options'); ?> <span class="table-content__block--line-distance2" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 1px;font-weight: 600;"><?php echo $email_data['rent_days'] ?></span></p>
					</div>
					<div class="table-content__block" style="font-size: 13px;float: left;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;min-width:49%;max-width:49%;display: inline-block;vertical-align: top;">
						<p class="table-content__block--line table-content__block--right-line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;padding-right: 0;"><?php echo get_field('email_rental_price', 'options'); ?> <span class="table-content__block--line-distance3" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 1px;"><?php echo $email_data['price_after_discount'] ?> <?php echo $email_data['Currency'] ?></span></p>
						<?php if($email_data['is_protected'] == 1): ?>
                        <p class="table-content__block--line table-content__block--right-line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;padding-right: 0;"><?php echo get_field('email_insurance', 'options'); ?> <span class="table-content__block--line-distance4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 12px;"><?php echo ( $email_data['PriceInsurance'] * $email_data['rent_days'] ) ?> <?php echo $email_data['Currency'] ?></span></p>
                        <p class="table-content__block--line table-content__block--right-line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;padding-right: 0;"><?php echo get_field('email_total_price', 'options'); ?> <span class="table-content__block--line-distance5" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 8px;"><?php echo ($email_data['price_after_discount'] + ( $email_data['PriceInsurance'] *  $email_data['rent_days']) ) ?> <?php echo $email_data['Currency'] ?></span></p>
                        <?php else: ?>
                        <p class="table-content__block--line table-content__block--right-line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;padding-right: 0px;"><?php echo get_field('email_total_price', 'options'); ?> <span class="table-content__block--line-distance5" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 8px;"><?php echo $email_data['price_after_discount'] ?> <?php echo $email_data['Currency'] ?></span></p>
						<?php endif ?>
					</div>
				</div>
			</div>

			<div class="email-info__rental-details email-details-table" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;border: 1px solid #d4dadd;margin-top: 20px;">
				<h1 class="email-details-table__title" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: inherit;color: #000000;margin: 0;font-size: 18px;font-weight: 500;line-height: 1.1;margin-top: 0px;margin-bottom: 10px;text-align: center;background-color: #d4dadd;padding-top: 5px;padding-bottom: 10px;"><?php echo get_field('email_rental_details', 'options'); ?></h1>
				<div class="email-details-table__content table-content rental-details_content" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;display: block;-webkit-flex-direction: row;flex-direction: row;align-items: flex-start;justify-content: space-between;padding-left: 21px;padding-top: 23px;padding-right: 21px;padding-bottom: 22px;">
					<div class="table-content__block" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;min-width:49%;max-width:49%;display: inline-block;vertical-align: top;">
						<p class="table-content__block--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_pick_up_location', 'options'); ?> <span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php echo $email_data['pickup_location']; echo $flight_details;?></span></p>
						<!--05/09/2022 added flight and no start

						<p class="table-content__block--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php //echo get_field('flight_airline', 'options'); ?> <span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php //echo $email_data['flight_airline'] ?></span></p>

						<p class="table-content__block--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php //echo get_field('flight_no', 'options'); ?> <span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php //echo $email_data['flight_no'] ?></span></p>

						05/09/2022 added flight and no end -->
						<p class="table-content__block--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_pick_up_date', 'options'); ?> <span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php echo date('M d Y H:i', strtotime($email_data['pickup_moment'])) ?></span></p>
					</div>
					<div class="table-content__block" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;min-width:49%;max-width:49%;display: inline-block;vertical-align: top;">
						<p class="table-content__block--line email-info__rental-details--right-line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;padding-right: 0;"><?php echo get_field('email_drop_off_location', 'options'); ?> <span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php echo $email_data['dropoff_location'] ?></span></p>
						<p class="table-content__block--line email-info__rental-details--right-line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;padding-right: 0;"><?php echo get_field('email_drop_off_date', 'options'); ?> <span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php echo date('M d Y H:i', strtotime($email_data['dropoff_moment'])) ?></span></p>
					</div>
				</div>
				<div class="table-content__bottom" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-left: 26px;padding-top: 13px;padding-right: 26px;padding-bottom: 14px;">
					<div class="table-content__bottom-block" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;">
						<p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;">Driver Age: <?php echo $email_data['AgeRange'] ?></p>
						<p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_car_type', 'options'); ?> <?php echo $email_data['CarTypeDesc'] ?> (<span class="table-content__block--bold" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;font-weight: 600;"><?php echo $email_data['GROUPNAME'] ?> <?php echo get_field('email_or_similar', 'options'); ?></span>)</p>
						<p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo $email_data['email_seats'] ?> <?php echo get_field('email_seats', 'options'); ?> | <?php echo $email_data['DoorsNum'] ?> <?php echo get_field('email_doors', 'options'); ?> | <?php echo ( ($email_data['SmallSuitcaseNum'] + $email_data['LargeSuitcaseNum']) / 2 ) ?> <?php echo get_field('email_small_bags', 'options'); ?> </p>               
						<p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo implode(', ', $features)?> </p>
						<p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_fuel_policy', 'options'); ?> <?php echo $email_data['FuelPolicyDesc'] ?></p>
						<?php if($email_data['is_protected'] == 1): ?>
                        <p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_full_protection', 'options'); ?></p>
						<?php endif?>
                        <p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_rates', 'options'); ?> <?php echo ($email_data['free_options']) ?></p>
						<p class="table-content__block--line " style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;padding-bottom: 4px;"><?php echo get_field('email_extra_equip', 'options'); ?> <?php echo ($email_data['equipment'] ? implode(', ', $email_data['equipment']) : 'none') ?></p>
					</div>


				</div>
			</div>
		</div>
		<div class="email-footer" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-top: 40px;padding-left: 2px;padding-bottom: 34px;">
			<div class="email-footer__regards" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;border-bottom: 1px solid #d4dadd;padding-bottom: 14px;">
				<p class="email-footer__regards--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;font-size: 12px;padding-bottom: 7px;"><?php echo get_field('email_kind_regards', 'options'); ?></p>
				<p class="email-footer__regards--line" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;orphans: 3;widows: 3;margin: 0;font-size: 12px;padding-bottom: 7px;"><?php echo get_field('email_your_autoshay', 'options'); ?></p>
			</div>
			<div class="email-footer__logo" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;padding-top: 18px;">
				<img src="<?php echo plugins_url( 'email/img/email_footer-logo.png' , dirname(__FILE__)) ?>" alt="footer_logo" class="" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: 'Open Sans', sans-serif;color: #010101;border: 0;vertical-align: middle;page-break-inside: avoid;border-style: none;max-width: 100%!important;">
			</div>
		</div>
	</div>

</body>
</html>
