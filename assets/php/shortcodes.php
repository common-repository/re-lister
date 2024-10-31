<?php

function cst_rel_listing_shortcode( $attr, $text ){
    global $post;
    $id = $post->ID;
    $val = '';
    
    //Location
    $loc = array( 'Street Address', 'Unit Number', 'City', 'State', 'Zip', 'Lat', 'Long', 'Display Address' );
    //Listing Details
    $list = array( 'Status', 'Price', 'Listing URL', 'MLS ID', 'MLS Name', 'Provider Listing ID', 'Virtual Tour URL', 'Listing Email', 'Always Email Agent', 'Short Sale', 'REO' );
    //Rental
    $rental = array( 'Availability', 'Lease Term', 'Deposit Fees');
    $utilities = array( 'Water', 'Sewage', 'Garbage', 'Electricity', 'Gas', 'Internet', 'Cable', 'SatTv');
    $pets = array( 'No Pets', 'Cats', 'Small Dogs', 'Large Dogs' );
    //Basic
    $basic = array( 'Property Type', 'Title', 'Description', 'Bedrooms', 'Bathrooms', 'Full Bathrooms', 'Half Bathrooms', 'Quarter Bathrooms', 'Three Quarter Bathrooms', 'Living Area', 'Lot Size', 'Year Built' );
    //Picture
    $picture = array( 'Picture URL', 'Caption' );
    //Agent (without Picture URL)
    $agent = array( 'First Name', 'Last Name', 'Email Address', 'Office Line Number', 'Mobile Phone Line Number', 'Fax Line Number', 'License Num' );
    //Office (without address info)
    $office = array( 'Brokerage Name', 'Broker Phone', 'Broker Email', 'Broker Website', 'Office Name', 'Franchise Name' );
    //Open House
    $openhouse = array( 'Date', 'Start Time', 'End Time' );
    //Schools
    $schools = array( 'District', 'Elementary', 'Middle', 'High' );
    //Neighborhood
    $neighborhood = array( 'Name' );
    //Fees
    $fees = array( 'Fee Type', 'Fee Amount', 'Fee Period' );
    //Rich Details
    $richdetails = array( 'Additional Features', 'Architecture Style', 'Attic', 'Barbecue Area', 'Basement', 'Building Unit Count', 'Cable Ready', 'Ceiling Fan', 'Condo Floor Num', 'Deck', 'Disabled Access', 'Dock', 'Doorman', 'Double Pane Windows', 'Elevator',  'Fireplace', 'Garden', 'Gated Entry', 'Greenhouse', 'Hottub/Spa', 'Intercom', 'Jetted Bath Tub', 'Lawn', 'Mother In Law', 'Num Floors', 'Num Parking Spaces', 'Patio', 'Pond', 'Pool', 'Porch', 'Room Count', 'RV Parking', 'Sauna', 'Security System', 'Skylight', 'Sports Court', 'Sprinkler System', 'Vaulted Ceiling', 'View Type', 'Fitness Center', 'Basketball Court', 'Tennis Court', 'Near Transportation', 'Controlled Access', 'Over 55 Active Community', 'Assisted Living Community', 'Storage', 'Fenced Yard', 'Property Name', 'Furnished', 'High Speed Internet', 'Onsite Laundry', 'Cable/Sat TV', 'Waterfront', 'Wetbar', 'What Owner Loves', 'Wired', 'Year Updated' );
    $appliances = array( 'Appliance' );
    $coolingsystems = array( 'Cooling System' );
    $exteriortypes = array( 'Exterior Type' );
    $floorcoverings = array( 'Floor Covering' );
    $heatingfuels = array( 'Heating Fuel' );
    $heatingsystems = array( 'Heating System' );
    $parkingtypes = array( 'Parking Type' );
    $rooftypes = array( 'Roof Type' );
    $rooms = array( 'Room' );
    $viewtypes = array( 'View Type' );
    
    $text = cst_rel_loop_shortcode_array( $loc, 'location', $text, $id );
    $text = cst_rel_loop_shortcode_array( $list, 'listingdetails', $text, $id );
    $text = cst_rel_loop_shortcode_array( $rental, 'rentaldetails', $text, $id );
    $text = cst_rel_loop_shortcode_array( $utilities, 'utilities', $text, $id );
    $text = cst_rel_loop_shortcode_array( $pets, 'petsallowed', $text, $id );
    $text = cst_rel_loop_shortcode_array( $basic, 'basicdetails', $text, $id );
    $text = cst_rel_loop_shortcode_array( $agent, 'agent', $text, $id );
    $text = cst_rel_loop_shortcode_array( $office, 'office', $text, $id );
    $text = cst_rel_loop_shortcode_array( $openhouse, 'openhouse', $text, $id );
    $text = cst_rel_loop_shortcode_array( $schools, 'schools', $text, $id );
    $text = cst_rel_loop_shortcode_array( $neighborhood, 'neighborhood', $text, $id );
    $text = cst_rel_loop_shortcode_array( $fees, 'fees', $text, $id );
    $text = cst_rel_loop_shortcode_array( $richdetails, 'richdetails', $text, $id );
    $text = cst_rel_loop_shortcode_array( $appliances, 'appliances', $text, $id );
    $text = cst_rel_loop_shortcode_array( $coolingsystems, 'coolingsystem', $text, $id );
    $text = cst_rel_loop_shortcode_array( $exteriortypes, 'exteriortypes', $text, $id );
    $text = cst_rel_loop_shortcode_array( $floorcoverings, 'floorcovering', $text, $id );
    $text = cst_rel_loop_shortcode_array( $heatingfuels, 'heatingfuels', $text, $id );
    $text = cst_rel_loop_shortcode_array( $heatingsystems, 'heatingsystem', $text, $id );
    $text = cst_rel_loop_shortcode_array( $parkingtypes, 'parkingtypes', $text, $id );
    $text = cst_rel_loop_shortcode_array( $rooftypes, 'rooftypes', $text, $id );
    $text = cst_rel_loop_shortcode_array( $rooms, 'rooms', $text, $id );
    
    return $text;
}
function cst_rel_loop_shortcode_array( $arr, $section, $text, $id ){
    $pref = '_cst_rel_meta_';
    $val = '';
    foreach ( $arr as $lbl ){
        $condensed = str_replace( ' ', '', $lbl);
        $meta_key = $pref . $section . '_' . strtolower( str_replace( ' ', '_', $lbl ) );
        $sc = '[' . $condensed . ']';
        if ( strpos( $text, $sc ) > 0 ) {
            $val = get_post_meta($id, $meta_key, true);
                $text = str_replace( $sc, $val, $text);
        }
    }
    return $text;
}
?>