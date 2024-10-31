<?php

/**
  * Field Reference Functions
  */

/* Set Form Fields */
//Location Fields
$location_fields;
function cst_rel_location_fields(){
    $location_fields = array(
        cst_rel_set_text_field( 'Street Address', 'single', '150', '40', 'first', 'yes', 'yes', 'no', 'Location' ),
        cst_rel_set_text_field( 'Unit Number', 'single', '10', '10', 'blank1', 'no', 'yes', 'no', 'Location' ),
        cst_rel_set_text_field( 'City', 'single', '50', '25', 'first', 'yes', 'yes', 'no', 'Location' ),
        array(
            'label' => 'State',
            'input_type' => 'select',
            'is_single' => 'single',
            'column' => 'middle',
            'required' => 'yes',
            'basic_data' => 'yes',
            'escaped' => 'no',
            'choices' => array(
                'AL',
                'AK',
                'AZ',
                'AR',
                'CA',
                'CO',
                'CT',
                'DE',
                'FL',
                'GA',
                'HI',
                'ID',
                'IL',
                'IN',
                'IA',
                'KS',
                'KY',
                'LA',
                'ME',
                'MD',
                'MA',
                'MI',
                'MN',
                'MS',
                'MO',
                'MT',
                'NE',
                'NV',
                'NH',
                'NJ',
                'NM',
                'NY',
                'NC',
                'ND',
                'OH',
                'OK',
                'OR',
                'PA',
                'RI',
                'SC',
                'SD',
                'TN',
                'TX',
                'UT',
                'VT',
                'VA',
                'WA',
                'WV',
                'WI',
                'WY',
            ),
            'default' => 0,
            'class' => 'select-short',
            'parent' => 'Location',
        ),
        cst_rel_set_text_field( 'Zip', 'single', '5', '10', 'last', 'yes', 'yes', 'no', 'Location' ),
        cst_rel_set_text_field( 'Lat', 'single', '10', '10', 'first', 'no', 'yes', 'no', 'Location' ),
        cst_rel_set_text_field( 'Long', 'single', '10', '10', 'middle', 'no', 'yes', 'no', 'Location' ),
        cst_rel_set_select_field( 'Display Address', 'single', 'last', 'no', 'yes', array('Yes', 'No'), 0, 'select-medium', 'Location' ),
    );
    return $location_fields;
}
//Listing Fields
$listing_fields;
function cst_rel_listing_fields(){
    $listing_fields = array(
        cst_rel_set_select_field ( 'Status', 'single', 'first', 'yes', 'yes', array('Active', 'Contingent', 'Pending', 'For Rent'), 0, 'select-large', 'ListingDetails' ),
        cst_rel_set_text_field( 'Price', 'single', '16', '10', 'blank1', 'yes', 'yes', 'no', 'ListingDetails' ),
        cst_rel_set_text_field( 'Listing URL', 'single', '50', '25', 'blank2', 'no', 'yes', 'yes', 'ListingDetails' ),
        cst_rel_set_text_field( 'MLS ID', 'single', '50', '25', 'first', 'no', 'yes', 'no', 'ListingDetails' ),
        cst_rel_set_text_field( 'MLS Name', 'single', '50', '25', 'middle', 'no', 'yes', 'no', 'ListingDetails' ),
        cst_rel_set_text_field( 'Provider Listing ID', 'single', '100', '25', 'last', 'no', 'no', 'no', 'ListingDetails' ),
        cst_rel_set_text_field( 'Virtual Tour URL', 'single', '50', '25', 'blank2', 'no', 'yes', 'yes', 'ListingDetails' ),
        cst_rel_set_text_field( 'Listing Email', 'single', '50', '25', 'first', 'no', 'no', 'no', 'ListingDetails' ),
        cst_rel_set_select_field ( 'Always Email Agent', 'single', 'middle', 'no', 'no', array('Yes', 'No'), 0, 'select-medium', 'ListingDetails' ),
        cst_rel_set_select_field ( 'Short Sale', 'single', 'last', 'no', 'yes', array('Yes', 'No'), 1, 'select-medium', 'ListingDetails' ),
        cst_rel_set_select_field ( 'REO', 'single', 'blank2', 'no', 'yes', array('Yes', 'No'), 1, 'select-medium', 'ListingDetails' ),
    );
    return $listing_fields;
}
//Rental Fields
$rental_fields;
function cst_rel_rental_fields(){
    $rental_fields = array(
        cst_rel_set_select_field( 'Availability', 'single', 'first', 'no', 'yes', array('Now', 'Contact for Details', 'Date'), 0, 'select-long', 'RentalDetails' ),
        cst_rel_set_select_field( 'Lease Term', 'single', 'middle', 'no', 'yes', array('Contact for Details', 'Monthly', 'Six Months', 'One Year', 'Rent to Own'), 0, 'select-long', 'RentalDetails' ),
        cst_rel_set_text_field( 'Deposit Fees', 'single', '20', '25', 'last', 'no', 'yes', 'no', 'RentalDetails' ),
        cst_rel_set_sublabel( 'Utilities Included', 'sublabel', 'RentalDetails' ),
        cst_rel_set_checkbox_field ( 'Water', 'first', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'Sewage', 'second', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'Garbage', 'third', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'Electricity', 'fourth', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'Gas', 'fifth', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'Internet', 'last', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'Cable', 'first', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_checkbox_field ( 'SatTv', 'blank1', 'no', 0, 'UtilitiesIncluded'  ),
        cst_rel_set_sublabel ( 'Pets Allowed' , 'sublabel', 'RentalDetails' ),
        cst_rel_set_select_field ( 'No Pets', 'single', 'first', 'no', 'yes', array('', 'Yes', 'No'), 0, 'select-short', 'PetsAllowed' ),
        cst_rel_set_select_field ( 'Cats', 'single', 'middle', 'no', 'yes', array('', 'Yes', 'No'), 0, 'select-short', 'PetsAllowed' ),
        cst_rel_set_select_field ( 'Small Dogs', 'single', 'last', 'no', 'yes', array('', 'Yes', 'No'), 0, 'select-short', 'PetsAllowed' ),
        cst_rel_set_select_field ( 'Large Dogs', 'single', 'blank2', 'no', 'yes', array('', 'Yes', 'No'), 0, 'select-short', 'PetsAllowed'),
    );
    return $rental_fields;
}
//Basic Fields
$basic_fields;
function cst_rel_basic_fields(){
    $basic_fields = array(
        cst_rel_set_select_field( 'Property Type', 'single', 'first', 'yes', 'yes', array( 'SingleFamily', 'Condo', 'Townhouse', 'Coop', 'MultiFamily', 'Manufactured', 'VacantLand', 'Other', 'Apartment' ), 0, 'select-long', 'BasicDetails' ),
        cst_rel_set_text_field( 'Title', 'single', '50', '25', 'middle', 'no', 'no', 'yes', 'BasicDetails' ),
        cst_rel_set_text_field( 'Description', 'single', '150', '25', 'last', 'no', 'no', 'yes', 'BasicDetails' ),
        cst_rel_set_select_field ( 'Bedrooms', 'single', 'first', 'no', 'yes', array('Studio', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), 0, 'select-large', 'BasicDetails' ),
        cst_rel_set_select_field ( 'Bathrooms', 'single', 'middle', 'no', 'yes', array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), 0, 'select-short', 'BasicDetails' ),
        cst_rel_set_select_field ( 'Full Bathrooms', 'single', 'last', 'no', 'yes', array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), 0, 'select-short', 'BasicDetails' ),
        cst_rel_set_select_field ( 'Half Bathrooms', 'single', 'first', 'no', 'yes', array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), 0, 'select-short', 'BasicDetails' ),
        cst_rel_set_select_field ( 'Quarter Bathrooms', 'single', 'middle', 'no', 'yes', array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), 0, 'select-short', 'BasicDetails' ),
        cst_rel_set_select_field ( 'Three Quarter Bathrooms', 'single', 'last', 'no', 'yes', array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), 0, 'select-short', 'BasicDetails' ),
        cst_rel_set_text_field( 'Living Area', 'single', '10', '10', 'first', 'no', 'yes', 'no', 'BasicDetails' ),
        cst_rel_set_text_field( 'Lot Size', 'single', '10', '10', 'middle', 'no', 'yes', 'no', 'BasicDetails' ),
        cst_rel_set_text_field( 'Year Built', 'single', '4', '10', 'last', 'no', 'yes', 'no', 'BasicDetails' ),
    );
    return $basic_fields;
}
//Picture Fields
$picture_fields;
function cst_rel_picture_fields(){
    $picture_fields = array(
        cst_rel_set_sublabel( 'Picture', 'sublabel', 'Pictures' ),
        cst_rel_set_text_field( 'Picture URL', 'single', '50', '25', 'first', 'no', 'no', 'yes', 'Picture' ),
        cst_rel_set_text_field( 'Caption', 'single', '100', '25', 'blank1', 'no', 'no', 'yes', 'Picture' ),
    );
    return $picture_fields;
}
//Agent Fields
$agent_fields;
function cst_rel_agent_fields(){
    $agent_fields = array(
        cst_rel_set_text_field( 'First Name', 'single', '25', '25', 'first', 'no', 'yes', 'no', 'Agent' ),
        cst_rel_set_text_field( 'Last Name', 'single', '25', '25', 'middle', 'no', 'yes', 'no', 'Agent' ),
        cst_rel_set_text_field( 'Email Address', 'single', '50', '25', 'last', 'yes', 'yes', 'no', 'Agent' ),
        cst_rel_set_text_field( 'Picture URL', 'single', '50', '25', 'blank2', 'no', 'no', 'yes', 'Agent' ),
        cst_rel_set_text_field( 'Office Line Number', 'single', '50', '25', 'first', 'no', 'yes', 'yes', 'Agent' ),
        cst_rel_set_text_field( 'Mobile Phone Line Number', 'single', '25', '25', 'middle', 'no', 'yes', 'yes', 'Agent' ),
        cst_rel_set_text_field( 'Fax Line Number', 'single', '25', '25', 'last', 'no', 'yes', 'yes', 'Agent' ),
        cst_rel_set_text_field( 'License Num', 'single', '25', '25', 'first', 'no', 'yes', 'yes', 'Agent' ),
    );
    return $agent_fields;
}
//Office Fields
$office_fields;
function cst_rel_office_fields(){
    $office_fields = array(
        cst_rel_set_text_field( 'Brokerage Name', 'single', '25', '25', 'first', 'no', 'yes', 'yes', 'Office' ),
        cst_rel_set_text_field( 'Broker Phone', 'single', '25', '25', 'middle', 'no', 'yes', 'no', 'Office' ),
        cst_rel_set_text_field( 'Broker Email', 'single', '50', '25', 'last', 'no', 'yes', 'no', 'Office' ),
        cst_rel_set_text_field( 'Broker Website', 'single', '50', '25', 'first', 'no', 'yes', 'yes', 'Office' ),
        cst_rel_set_text_field( 'Street Address', 'single', '50', '25', 'middle', 'no', 'yes', 'no', 'Office' ),
        cst_rel_set_text_field( 'Unit Number', 'single', '10', '10', 'last', 'no', 'yes', 'no', 'Office' ),
        cst_rel_set_text_field( 'City', 'single', '25', '10', 'first', 'no', 'yes', 'no', 'Office' ),
        array(
            'label' => 'State',
            'input_type' => 'select',
            'is_single' => 'single',
            'column' => 'middle',
            'required' => 'no',
            'basic_data' => 'yes',
            'escaped' => 'no',
            'choices' => array(
                'AL',
                'AK',
                'AZ',
                'AR',
                'CA',
                'CO',
                'CT',
                'DE',
                'FL',
                'GA',
                'HI',
                'ID',
                'IL',
                'IN',
                'IA',
                'KS',
                'KY',
                'LA',
                'ME',
                'MD',
                'MA',
                'MI',
                'MN',
                'MS',
                'MO',
                'MT',
                'NE',
                'NV',
                'NH',
                'NJ',
                'NM',
                'NY',
                'NC',
                'ND',
                'OH',
                'OK',
                'OR',
                'PA',
                'RI',
                'SC',
                'SD',
                'TN',
                'TX',
                'UT',
                'VT',
                'VA',
                'WA',
                'WV',
                'WI',
                'WY',
            ),
            'default' => 0,
            'class' => 'select-short',
            'parent' => 'Office'
        ),
        cst_rel_set_text_field( 'Zip', 'single', '5', '10', 'last', 'no', 'yes', 'no', 'Office' ),
        cst_rel_set_text_field( 'Office Name', 'single', '25', '25', 'first', 'no', 'yes', 'yes', 'Office' ),
        cst_rel_set_text_field( 'Franchise Name', 'single', '25', '25', 'blank1', 'no', 'yes', 'yes', 'Office' ),
    );
    return $office_fields;
}
//Open House Fields
$openhouse_fields;
function cst_rel_openhouse_fields(){
    $openhouse_fields = array(
        cst_rel_set_sublabel( 'Open House', 'sublabel', 'OpenHouses' ),
        cst_rel_set_text_field( 'Date', 'single', '10', '10', 'first', 'no', 'yes', 'no', 'OpenHouse' ),
        cst_rel_set_text_field( 'Start Time', 'single', '10', '10', 'middle', 'no', 'yes', 'no', 'OpenHouse' ),
        cst_rel_set_text_field( 'End Time', 'single', '10', '10', 'last', 'no', 'yes', 'no', 'OpenHouse' ),
    );
    return $openhouse_fields;
}
//Schools Fields
$schools_fields;
function cst_rel_schools_fields(){
    $schools_fields = array(
        cst_rel_set_text_field( 'District', 'single', '25', '25', 'first', 'no', 'yes', 'no', 'Schools' ),
        cst_rel_set_text_field( 'Elementary', 'single', '25', '25', 'middle', 'no', 'yes', 'no', 'Schools' ),
        cst_rel_set_text_field( 'Middle', 'single', '25', '25', 'last', 'no', 'yes', 'no', 'Schools' ),
        cst_rel_set_text_field( 'High', 'single', '25', '25', 'blank2', 'no', 'yes', 'no', 'Schools' ),
    );
    return $schools_fields;
}
//Neighborhood Fields
$neighborhood_fields;
function cst_rel_neighborhood_fields(){
    $neighborhood_fields = array(
        cst_rel_set_text_field( 'Name', 'single', '25', '25', 'first', 'no', 'yes', 'no', 'Neighborhood' ),
    );
    return $neighborhood_fields;
}
//Fees Fields
$fees_fields;
function cst_rel_fees_fields(){
    $fees_fields = array(
        cst_rel_set_sublabel( 'Fee', 'sublabel', 'Fees' ),
        cst_rel_set_select_field( 'Fee Type', 'single', 'first', 'no', 'yes', array( '', 'HOA', 'Maintenance', 'Common Charges' ), 0, 'select-short', 'Fee' ),
        cst_rel_set_text_field( 'Fee Amount', 'single', '10', '10', 'middle', 'no', 'yes', 'no', 'Fee' ),
        cst_rel_set_select_field( 'Fee Period', 'single', 'last', 'no', 'yes', array( 'monthly', 'quarterly', 'annually' ), 0, 'select-large', 'Fee' ),
    );
    return $fees_fields;
}
//Rich Details Fields
$rich_details_fields;
function cst_rel_rich_details_fields(){
    $rich_details_fields = array(
        cst_rel_set_text_field( 'Additional Features', 'single', '150', '50', 'blank2', 'no', 'yes', 'yes', 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Appliances', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Appliance', 'single', 'blank2', 'no', 'yes', array( '', 'Dishwasher', 'Dryer', 'Freezer', 'Garbage Disposal', 'Microwave', 'Range Oven', 'Refrigerator', 'Trash Compactor', 'Washer' ), 0, 'select-long', 'Appliances' ),
        
        cst_rel_set_select_field( 'Architecture Style', 'single', 'blank2', 'no', 'yes', array( '', 'Bungalow', 'Cape Cod', 'Colonial', 'Contemporary', 'Craftsman', 'French', 'Georgian', 'Loft', 'Modern', 'Queen Anne Victorian', 'Ranch Rambler', 'Santa Fe Pueblo Style', 'Spanish', 'Split-level', 'Tudor', 'Other' ), 0, 'select-long', 'RichDetails' ),
        cst_rel_set_checkbox_field ( 'Attic', 'first', 'no', 0, 'RichDetails'  ),
        cst_rel_set_checkbox_field( 'Barbecue Area', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Basement', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_text_field( 'Building Unit Count', 'single', '10', '10', 'middle', 'no', 'yes', 'no', 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Cable Ready', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Ceiling Fan', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_text_field( 'Condo Floor Num', 'single', '10', '10', 'blank1', 'no', 'yes', 'no', 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Cooling Systems', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Cooling System', 'single', 'blank2', 'no', 'yes', array( '', 'None', 'Central', 'Evaporative', 'Geothermal', 'Wall', 'Solar', 'Other' ), 0, 'select-long', 'CoolingSystems' ),
        
        cst_rel_set_checkbox_field( 'Deck', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Disabled Access', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Dock', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Doorman', 'fourth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Double Pane Windows', 'fifth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Elevator', 'last', 'no', 0, 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Exterior Types', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Exterior Type', 'single', 'blank2', 'no', 'yes', array( '', 'Brick', 'Cement Concrete', 'Composition', 'Metal', 'Shingle', 'Stone', 'Stucco', 'Vinyl', 'Wood', 'Wood Products', 'Other' ), 0, 'select-long', 'ExteriorTypes' ),
        
        cst_rel_set_checkbox_field( 'Fireplace', 'first', 'no', 0, 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Floor Coverings', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Floor Covering', 'single', 'blank2', 'no', 'yes', array( '', 'Carpet', 'Concrete', 'Hardwood', 'Laminate', 'Linoleum Vinyl', 'Slate', 'Softwood', 'Tile', 'Other' ), 0, 'select-long', 'FloorCoverings' ),
        
        cst_rel_set_checkbox_field( 'Garden', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Gated Entry', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Greenhouse', 'third', 'no', 0, 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Heating Fuels', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Heating Fuel', 'single', 'blank2', 'no', 'yes', array( '', 'None', 'Coal', 'Electric', 'Gas', 'Oil', 'Propane Butane', 'Solar', 'Wood Pellet', 'Other' ), 0, 'select-long', 'HeatingFuels' ),
        
        cst_rel_set_sublabel( 'Heating Sytems', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Heating System', 'single', 'blank2', 'no', 'yes', array( '', 'Baseboard', 'Forced Air', 'Heat Pump', 'Radiant', 'Stove', 'Wall', 'Other' ), 0, 'select-long', 'HeatingSystems' ),
        
        cst_rel_set_checkbox_field( 'Hottub/Spa', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Intercom', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Jetted Bath Tub', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Lawn', 'fourth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Mother In Law', 'last', 'no', 0, 'RichDetails' ),
        cst_rel_set_text_field( 'Num Floors', 'single', '10', '10', 'first', 'no', 'yes', 'no', 'RichDetails' ),
        cst_rel_set_text_field( 'Num Parking Spaces', 'single', '10', '10', 'blank2', 'no', 'yes', 'no', 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Parking Types', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Parking Type', 'single', 'blank2', 'no', 'yes', array( '', 'Carport', 'Garage Attached', 'Garage Detached', 'Off Street', 'On Street', 'None' ), 0, 'select-long', 'ParkingTypes' ),
        
        cst_rel_set_checkbox_field( 'Patio', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Pond', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Pool', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Porch', 'last', 'no', 0, 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Roof Types', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Roof Type', 'single', 'blank2', 'no', 'yes', array( '', 'Asphalt', 'Built Up', 'Composition', 'Metal', 'Shake Shingle', 'Slate', 'Tile', 'Other'), 0, 'select-long', 'RoofTypes' ),
        
        cst_rel_set_text_field( 'Room Count', 'single', '10', '10', 'blank2', 'no', 'yes', 'no', 'RichDetails' ),
        
        cst_rel_set_sublabel( 'Rooms', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'Room', 'single', 'blank2', 'no', 'yes', array( '', 'Breakfast Nook', 'Dining Room', 'Family Room', 'Laundry Room', 'Library', 'Master Bath', 'Mud Room', 'Office', 'Pantry', 'Recreation Room', 'Workshop', 'Solarium Atrium', 'Sun Room', 'Walk In Closet'), 0, 'select-long', 'Rooms' ),
        
        cst_rel_set_checkbox_field( 'RV Parking', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Sauna', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Security System', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Skylight', 'fourth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Sports Court', 'fifth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Sprinkler System', 'last', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Vaulted Ceiling', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Fitness Center', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Basketball Court', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Tennis Court', 'fourth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Near Transportation', 'fifth', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Controlled Access', 'last', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Over 55 Active Community', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Assisted Living Community', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Storage', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Fenced Yard', 'last', 'no', 0, 'RichDetails' ),
        cst_rel_set_text_field( 'Property Name', 'single', '25', '25', 'middle', 'no', 'yes', 'no', 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Furnished', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'High Speed Internet', 'second', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Onsite Laundry', 'third', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Cable/Sat TV', 'last', 'no', 0, 'RichDetails' ),
        
        cst_rel_set_sublabel( 'View Types', 'sublabel', 'RichDetails' ),
        cst_rel_set_select_field( 'View Type', 'single', 'blank2', 'no', 'yes', array( '', 'None', 'City', 'Mountain', 'Park', 'Territorial', 'Water' ), 0, 'select-long', 'ViewTypes' ),
        cst_rel_set_checkbox_field( 'Waterfront', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Wetbar', 'last', 'no', 0, 'RichDetails' ),
        cst_rel_set_text_field( 'What Owner Loves', 'single', '100', '50', 'last', 'no', 'yes', 'no', 'RichDetails' ),
        cst_rel_set_checkbox_field( 'Wired', 'first', 'no', 0, 'RichDetails' ),
        cst_rel_set_text_field( 'Year Updated', 'single', '4', '10', 'blank1', 'no', 'yes', 'no', 'RichDetails' ),
    );
    return $rich_details_fields;
}

/* Set All Form Fields */
function cst_rel_set_all_fields(){
    $all_fields = array(
    cst_rel_location_fields(),
    cst_rel_listing_fields(),
    cst_rel_rental_fields(),
    cst_rel_basic_fields(),
    cst_rel_picture_fields(),
    cst_rel_agent_fields(),
    cst_rel_office_fields(),
    cst_rel_openhouse_fields(),
    cst_rel_schools_fields(),
    cst_rel_neighborhood_fields(),
    cst_rel_fees_fields(),
    cst_rel_rich_details_fields(),
    );
    return $all_fields;
}

?>