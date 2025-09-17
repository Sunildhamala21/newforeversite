@extends('layouts.admin')
@push('styles')
    <link href="./assets/vendors/bootstrap-rating-master/bootstrap-rating.css" rel="stylesheet">
@endpush
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form"
                          id="add-form-page"
                          enctype="multipart/form-data">
                        <input type="hidden"
                               name="id"
                               value="{{ $trip_review->id }}">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-edit-1"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Edit Trip Review
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.trip-reviews.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-check-mark"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text"
                                       value="{{ $trip_review->title }}"
                                       name="title"
                                       class="form-control"
                                       placeholder=""
                                       required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Trip</label>
                                <select class="custom-select form-control form-control-sm" name="trip_id">
                                    <option value="">--Select Trip--</option>
                                    @foreach ($trips as $trip)
                                        <option value="{{ $trip->id }}" <?php echo $trip_review->trip_id == $trip->id ? 'selected' : ''; ?>>{{ $trip->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Reviewer Name</label>
                                <input type="text"
                                       value="{{ $trip_review->review_name }}"
                                       name="review_name"
                                       class="form-control"
                                       placeholder=""
                                       required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="country">Reviewer Country</label>
                                <select id="country"
                                        name="review_country"
                                        class="form-control">
                                    <option value="">--Select Country--</option>
                                    <option value="Afghanistan" <?php echo $trip_review->review_country == 'Afghanistan' ? 'selected' : ''; ?>>Afghanistan</option>
                                    <option value="Åland Islands" <?php echo $trip_review->review_country == 'Åland Islands' ? 'selected' : ''; ?>>Åland Islands</option>
                                    <option value="Albania" <?php echo $trip_review->review_country == 'Albania' ? 'selected' : ''; ?>>Albania</option>
                                    <option value="Algeria" <?php echo $trip_review->review_country == 'Algeria' ? 'selected' : ''; ?>>Algeria</option>
                                    <option value="American Samoa" <?php echo $trip_review->review_country == 'American Samoa' ? 'selected' : ''; ?>>American Samoa</option>
                                    <option value="Andorra" <?php echo $trip_review->review_country == 'Andorra' ? 'selected' : ''; ?>>Andorra</option>
                                    <option value="Angola" <?php echo $trip_review->review_country == 'Angola' ? 'selected' : ''; ?>>Angola</option>
                                    <option value="Anguilla" <?php echo $trip_review->review_country == 'Anguilla' ? 'selected' : ''; ?>>Anguilla</option>
                                    <option value="Antarctica" <?php echo $trip_review->review_country == 'Antarctica' ? 'selected' : ''; ?>>Antarctica</option>
                                    <option value="Antigua and Barbuda" <?php echo $trip_review->review_country == 'Antigua and Barbuda' ? 'selected' : ''; ?>>Antigua and Barbuda</option>
                                    <option value="Argentina" <?php echo $trip_review->review_country == 'Argentina' ? 'selected' : ''; ?>>Argentina</option>
                                    <option value="Armenia" <?php echo $trip_review->review_country == 'Armenia' ? 'selected' : ''; ?>>Armenia</option>
                                    <option value="Aruba" <?php echo $trip_review->review_country == 'Aruba' ? 'selected' : ''; ?>>Aruba</option>
                                    <option value="Australia" <?php echo $trip_review->review_country == 'Australia' ? 'selected' : ''; ?>>Australia</option>
                                    <option value="Austria" <?php echo $trip_review->review_country == 'Austria' ? 'selected' : ''; ?>>Austria</option>
                                    <option value="Azerbaijan" <?php echo $trip_review->review_country == 'Azerbaijan' ? 'selected' : ''; ?>>Azerbaijan</option>
                                    <option value="Bahamas" <?php echo $trip_review->review_country == 'Bahamas' ? 'selected' : ''; ?>>Bahamas</option>
                                    <option value="Bahrain" <?php echo $trip_review->review_country == 'Bahrain' ? 'selected' : ''; ?>>Bahrain</option>
                                    <option value="Bangladesh" <?php echo $trip_review->review_country == 'Bangladesh' ? 'selected' : ''; ?>>Bangladesh</option>
                                    <option value="Barbados" <?php echo $trip_review->review_country == 'Barbados' ? 'selected' : ''; ?>>Barbados</option>
                                    <option value="Belarus" <?php echo $trip_review->review_country == 'Belarus' ? 'selected' : ''; ?>>Belarus</option>
                                    <option value="Belgium" <?php echo $trip_review->review_country == 'Belgium' ? 'selected' : ''; ?>>Belgium</option>
                                    <option value="Belize" <?php echo $trip_review->review_country == 'Belize' ? 'selected' : ''; ?>>Belize</option>
                                    <option value="Benin" <?php echo $trip_review->review_country == 'Benin' ? 'selected' : ''; ?>>Benin</option>
                                    <option value="Bermuda" <?php echo $trip_review->review_country == 'Bermuda' ? 'selected' : ''; ?>>Bermuda</option>
                                    <option value="Bhutan" <?php echo $trip_review->review_country == 'Bhutan' ? 'selected' : ''; ?>>Bhutan</option>
                                    <option value="Bolivia" <?php echo $trip_review->review_country == 'Bolivia' ? 'selected' : ''; ?>>Bolivia</option>
                                    <option value="Bosnia and Herzegovina" <?php echo $trip_review->review_country == 'Bosnia and Herzegovina' ? 'selected' : ''; ?>>Bosnia and Herzegovina</option>
                                    <option value="Botswana" <?php echo $trip_review->review_country == 'Botswana' ? 'selected' : ''; ?>>Botswana</option>
                                    <option value="Bouvet Island" <?php echo $trip_review->review_country == 'Bouvet Island' ? 'selected' : ''; ?>>Bouvet Island</option>
                                    <option value="Brazil" <?php echo $trip_review->review_country == 'Brazil' ? 'selected' : ''; ?>>Brazil</option>
                                    <option value="British Indian Ocean Territory" <?php echo $trip_review->review_country == 'British Indian Ocean Territory' ? 'selected' : ''; ?>>British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam" <?php echo $trip_review->review_country == 'Brunei Darussalam' ? 'selected' : ''; ?>>Brunei Darussalam</option>
                                    <option value="Bulgaria" <?php echo $trip_review->review_country == 'Bulgaria' ? 'selected' : ''; ?>>Bulgaria</option>
                                    <option value="Burkina Faso" <?php echo $trip_review->review_country == 'Burkina Faso' ? 'selected' : ''; ?>>Burkina Faso</option>
                                    <option value="Burundi" <?php echo $trip_review->review_country == 'Burundi' ? 'selected' : ''; ?>>Burundi</option>
                                    <option value="Cambodia" <?php echo $trip_review->review_country == 'Cambodia' ? 'selected' : ''; ?>>Cambodia</option>
                                    <option value="Cameroon" <?php echo $trip_review->review_country == 'Cameroon' ? 'selected' : ''; ?>>Cameroon</option>
                                    <option value="Canada" <?php echo $trip_review->review_country == 'Canada' ? 'selected' : ''; ?>>Canada</option>
                                    <option value="Cape Verde" <?php echo $trip_review->review_country == 'Cape Verde' ? 'selected' : ''; ?>>Cape Verde</option>
                                    <option value="Cayman Islands" <?php echo $trip_review->review_country == 'Cayman Islands' ? 'selected' : ''; ?>>Cayman Islands</option>
                                    <option value="Central African Republic" <?php echo $trip_review->review_country == 'Central African Republic' ? 'selected' : ''; ?>>Central African Republic</option>
                                    <option value="Chad" <?php echo $trip_review->review_country == 'Chad' ? 'selected' : ''; ?>>Chad</option>
                                    <option value="Chile" <?php echo $trip_review->review_country == 'Chile' ? 'selected' : ''; ?>>Chile</option>
                                    <option value="China" <?php echo $trip_review->review_country == 'China' ? 'selected' : ''; ?>>China</option>
                                    <option value="Christmas Island" <?php echo $trip_review->review_country == 'Christmas Island' ? 'selected' : ''; ?>>Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands" <?php echo $trip_review->review_country == 'Cocos (Keeling) Islands' ? 'selected' : ''; ?>>Cocos (Keeling) Islands</option>
                                    <option value="Colombia" <?php echo $trip_review->review_country == 'Colombia' ? 'selected' : ''; ?>>Colombia</option>
                                    <option value="Comoros" <?php echo $trip_review->review_country == 'Comoros' ? 'selected' : ''; ?>>Comoros</option>
                                    <option value="Congo" <?php echo $trip_review->review_country == 'Congo' ? 'selected' : ''; ?>>Congo</option>
                                    <option value="Congo, The Democratic Republic of The" <?php echo $trip_review->review_country == 'Congo, The Democratic Republic of The' ? 'selected' : ''; ?>>Congo, The Democratic Republic of The</option>
                                    <option value="Cook Islands" <?php echo $trip_review->review_country == 'Cook Islands' ? 'selected' : ''; ?>>Cook Islands</option>
                                    <option value="Costa Rica" <?php echo $trip_review->review_country == 'Costa Rica' ? 'selected' : ''; ?>>Costa Rica</option>
                                    <option value="Cote D'ivoire" <?php echo $trip_review->review_country == "Cote D'ivoire" ? 'selected' : ''; ?>>Cote D'ivoire</option>
                                    <option value="Croatia" <?php echo $trip_review->review_country == 'Croatia' ? 'selected' : ''; ?>>Croatia</option>
                                    <option value="Cuba" <?php echo $trip_review->review_country == 'Cuba' ? 'selected' : ''; ?>>Cuba</option>
                                    <option value="Cyprus" <?php echo $trip_review->review_country == 'Cyprus' ? 'selected' : ''; ?>>Cyprus</option>
                                    <option value="Czech Republic" <?php echo $trip_review->review_country == 'Czech Republic' ? 'selected' : ''; ?>>Czech Republic</option>
                                    <option value="Denmark" <?php echo $trip_review->review_country == 'Denmark' ? 'selected' : ''; ?>>Denmark</option>
                                    <option value="Djibouti" <?php echo $trip_review->review_country == 'Djibouti' ? 'selected' : ''; ?>>Djibouti</option>
                                    <option value="Dominica" <?php echo $trip_review->review_country == 'Dominica' ? 'selected' : ''; ?>>Dominica</option>
                                    <option value="Dominican Republic" <?php echo $trip_review->review_country == 'Dominican Republic' ? 'selected' : ''; ?>>Dominican Republic</option>
                                    <option value="Ecuador" <?php echo $trip_review->review_country == 'Ecuador' ? 'selected' : ''; ?>>Ecuador</option>
                                    <option value="Egypt" <?php echo $trip_review->review_country == 'Egypt' ? 'selected' : ''; ?>>Egypt</option>
                                    <option value="El Salvador" <?php echo $trip_review->review_country == 'El Salvador' ? 'selected' : ''; ?>>El Salvador</option>
                                    <option value="Equatorial Guinea" <?php echo $trip_review->review_country == 'Equatorial Guinea' ? 'selected' : ''; ?>>Equatorial Guinea</option>
                                    <option value="Eritrea" <?php echo $trip_review->review_country == 'Eritrea' ? 'selected' : ''; ?>>Eritrea</option>
                                    <option value="Estonia" <?php echo $trip_review->review_country == 'Estonia' ? 'selected' : ''; ?>>Estonia</option>
                                    <option value="Ethiopia" <?php echo $trip_review->review_country == 'Ethiopia' ? 'selected' : ''; ?>>Ethiopia</option>
                                    <option value="Falkland Islands (Malvinas)" <?php echo $trip_review->review_country == 'Falkland Islands (Malvinas)' ? 'selected' : ''; ?>>Falkland Islands (Malvinas)</option>
                                    <option value="Faroe Islands" <?php echo $trip_review->review_country == 'Faroe Islands' ? 'selected' : ''; ?>>Faroe Islands</option>
                                    <option value="Fiji" <?php echo $trip_review->review_country == 'Fiji' ? 'selected' : ''; ?>>Fiji</option>
                                    <option value="Finland" <?php echo $trip_review->review_country == 'Finland' ? 'selected' : ''; ?>>Finland</option>
                                    <option value="France" <?php echo $trip_review->review_country == 'France' ? 'selected' : ''; ?>>France</option>
                                    <option value="French Guiana" <?php echo $trip_review->review_country == 'French Guiana' ? 'selected' : ''; ?>>French Guiana</option>
                                    <option value="French Polynesia" <?php echo $trip_review->review_country == 'French Polynesia' ? 'selected' : ''; ?>>French Polynesia</option>
                                    <option value="French Southern Territories" <?php echo $trip_review->review_country == 'French Southern Territories' ? 'selected' : ''; ?>>French Southern Territories</option>
                                    <option value="Gabon" <?php echo $trip_review->review_country == 'Gabon' ? 'selected' : ''; ?>>Gabon</option>
                                    <option value="Gambia" <?php echo $trip_review->review_country == 'Gambia' ? 'selected' : ''; ?>>Gambia</option>
                                    <option value="Georgia" <?php echo $trip_review->review_country == 'Georgia' ? 'selected' : ''; ?>>Georgia</option>
                                    <option value="Germany" <?php echo $trip_review->review_country == 'Germany' ? 'selected' : ''; ?>>Germany</option>
                                    <option value="Ghana" <?php echo $trip_review->review_country == 'Ghana' ? 'selected' : ''; ?>>Ghana</option>
                                    <option value="Gibraltar" <?php echo $trip_review->review_country == 'Gibraltar' ? 'selected' : ''; ?>>Gibraltar</option>
                                    <option value="Greece" <?php echo $trip_review->review_country == 'Greece' ? 'selected' : ''; ?>>Greece</option>
                                    <option value="Greenland" <?php echo $trip_review->review_country == 'Greenland' ? 'selected' : ''; ?>>Greenland</option>
                                    <option value="Grenada" <?php echo $trip_review->review_country == 'Grenada' ? 'selected' : ''; ?>>Grenada</option>
                                    <option value="Guadeloupe" <?php echo $trip_review->review_country == 'Guadeloupe' ? 'selected' : ''; ?>>Guadeloupe</option>
                                    <option value="Guam" <?php echo $trip_review->review_country == 'Guam' ? 'selected' : ''; ?>>Guam</option>
                                    <option value="Guatemala" <?php echo $trip_review->review_country == 'Guatemala' ? 'selected' : ''; ?>>Guatemala</option>
                                    <option value="Guernsey" <?php echo $trip_review->review_country == 'Guernsey' ? 'selected' : ''; ?>>Guernsey</option>
                                    <option value="Guinea" <?php echo $trip_review->review_country == 'Guinea' ? 'selected' : ''; ?>>Guinea</option>
                                    <option value="Guinea-bissau" <?php echo $trip_review->review_country == 'Guinea-bissau' ? 'selected' : ''; ?>>Guinea-bissau</option>
                                    <option value="Guyana" <?php echo $trip_review->review_country == 'Guyana' ? 'selected' : ''; ?>>Guyana</option>
                                    <option value="Haiti" <?php echo $trip_review->review_country == 'Haiti' ? 'selected' : ''; ?>>Haiti</option>
                                    <option value="Heard Island and Mcdonald Islands" <?php echo $trip_review->review_country == 'Heard Island and Mcdonald Islands' ? 'selected' : ''; ?>>Heard Island and Mcdonald Islands</option>
                                    <option value="Holy See (Vatican City State)" <?php echo $trip_review->review_country == 'Holy See (Vatican City State)' ? 'selected' : ''; ?>>Holy See (Vatican City State)</option>
                                    <option value="Honduras" <?php echo $trip_review->review_country == 'Honduras' ? 'selected' : ''; ?>>Honduras</option>
                                    <option value="Hong Kong" <?php echo $trip_review->review_country == 'Hong Kong' ? 'selected' : ''; ?>>Hong Kong</option>
                                    <option value="Hungary" <?php echo $trip_review->review_country == 'Hungary' ? 'selected' : ''; ?>>Hungary</option>
                                    <option value="Iceland" <?php echo $trip_review->review_country == 'Iceland' ? 'selected' : ''; ?>>Iceland</option>
                                    <option value="India" <?php echo $trip_review->review_country == 'India' ? 'selected' : ''; ?>>India</option>
                                    <option value="Indonesia" <?php echo $trip_review->review_country == 'Indonesia' ? 'selected' : ''; ?>>Indonesia</option>
                                    <option value="Iran, Islamic Republic of" <?php echo $trip_review->review_country == 'Iran, Islamic Republic of' ? 'selected' : ''; ?>>Iran, Islamic Republic of</option>
                                    <option value="Iraq" <?php echo $trip_review->review_country == 'Iraq' ? 'selected' : ''; ?>>Iraq</option>
                                    <option value="Ireland" <?php echo $trip_review->review_country == 'Ireland' ? 'selected' : ''; ?>>Ireland</option>
                                    <option value="Isle of Man" <?php echo $trip_review->review_country == 'Isle of Man' ? 'selected' : ''; ?>>Isle of Man</option>
                                    <option value="Israel" <?php echo $trip_review->review_country == 'Israel' ? 'selected' : ''; ?>>Israel</option>
                                    <option value="Italy" <?php echo $trip_review->review_country == 'Italy' ? 'selected' : ''; ?>>Italy</option>
                                    <option value="Jamaica" <?php echo $trip_review->review_country == 'Jamaica' ? 'selected' : ''; ?>>Jamaica</option>
                                    <option value="Japan" <?php echo $trip_review->review_country == 'Japan' ? 'selected' : ''; ?>>Japan</option>
                                    <option value="Jersey" <?php echo $trip_review->review_country == 'Jersey' ? 'selected' : ''; ?>>Jersey</option>
                                    <option value="Jordan" <?php echo $trip_review->review_country == 'Jordan' ? 'selected' : ''; ?>>Jordan</option>
                                    <option value="Kazakhstan" <?php echo $trip_review->review_country == 'Kazakhstan' ? 'selected' : ''; ?>>Kazakhstan</option>
                                    <option value="Kenya" <?php echo $trip_review->review_country == 'Kenya' ? 'selected' : ''; ?>>Kenya</option>
                                    <option value="Kiribati" <?php echo $trip_review->review_country == 'Kiribati' ? 'selected' : ''; ?>>Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of" <?php echo $trip_review->review_country == "Korea, Democratic People's Republic of" ? 'selected' : ''; ?>>Korea, Democratic People's Republic of</option>
                                    <option value="Korea, Republic of" <?php echo $trip_review->review_country == 'Korea, Republic of' ? 'selected' : ''; ?>>Korea, Republic of</option>
                                    <option value="Kuwait" <?php echo $trip_review->review_country == 'Kuwait' ? 'selected' : ''; ?>>Kuwait</option>
                                    <option value="Kyrgyzstan" <?php echo $trip_review->review_country == 'Kyrgyzstan' ? 'selected' : ''; ?>>Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic" <?php echo $trip_review->review_country == "Lao People's Democratic Republic" ? 'selected' : ''; ?>>Lao People's Democratic Republic</option>
                                    <option value="Latvia" <?php echo $trip_review->review_country == 'Latvia' ? 'selected' : ''; ?>>Latvia</option>
                                    <option value="Lebanon" <?php echo $trip_review->review_country == 'Lebanon' ? 'selected' : ''; ?>>Lebanon</option>
                                    <option value="Lesotho" <?php echo $trip_review->review_country == 'Lesotho' ? 'selected' : ''; ?>>Lesotho</option>
                                    <option value="Liberia" <?php echo $trip_review->review_country == 'Liberia' ? 'selected' : ''; ?>>Liberia</option>
                                    <option value="Libyan Arab Jamahiriya" <?php echo $trip_review->review_country == 'Libyan Arab Jamahiriya' ? 'selected' : ''; ?>>Libyan Arab Jamahiriya</option>
                                    <option value="Liechtenstein" <?php echo $trip_review->review_country == 'Liechtenstein' ? 'selected' : ''; ?>>Liechtenstein</option>
                                    <option value="Lithuania" <?php echo $trip_review->review_country == 'Lithuania' ? 'selected' : ''; ?>>Lithuania</option>
                                    <option value="Luxembourg" <?php echo $trip_review->review_country == 'Luxembourg' ? 'selected' : ''; ?>>Luxembourg</option>
                                    <option value="Macao" <?php echo $trip_review->review_country == 'Macao' ? 'selected' : ''; ?>>Macao</option>
                                    <option value="Macedonia, The Former Yugoslav Republic of" <?php echo $trip_review->review_country == 'Macedonia, The Former Yugoslav Republic of' ? 'selected' : ''; ?>>Macedonia, The Former Yugoslav Republic of</option>
                                    <option value="Madagascar" <?php echo $trip_review->review_country == 'Madagascar' ? 'selected' : ''; ?>>Madagascar</option>
                                    <option value="Malawi" <?php echo $trip_review->review_country == 'Malawi' ? 'selected' : ''; ?>>Malawi</option>
                                    <option value="Malaysia" <?php echo $trip_review->review_country == 'Malaysia' ? 'selected' : ''; ?>>Malaysia</option>
                                    <option value="Maldives" <?php echo $trip_review->review_country == 'Maldives' ? 'selected' : ''; ?>>Maldives</option>
                                    <option value="Mali" <?php echo $trip_review->review_country == 'Mali' ? 'selected' : ''; ?>>Mali</option>
                                    <option value="Malta" <?php echo $trip_review->review_country == 'Malta' ? 'selected' : ''; ?>>Malta</option>
                                    <option value="Marshall Islands" <?php echo $trip_review->review_country == 'Marshall Islands' ? 'selected' : ''; ?>>Marshall Islands</option>
                                    <option value="Martinique" <?php echo $trip_review->review_country == 'Martinique' ? 'selected' : ''; ?>>Martinique</option>
                                    <option value="Mauritania" <?php echo $trip_review->review_country == 'Mauritania' ? 'selected' : ''; ?>>Mauritania</option>
                                    <option value="Mauritius" <?php echo $trip_review->review_country == 'Mauritius' ? 'selected' : ''; ?>>Mauritius</option>
                                    <option value="Mayotte" <?php echo $trip_review->review_country == 'Mayotte' ? 'selected' : ''; ?>>Mayotte</option>
                                    <option value="Mexico" <?php echo $trip_review->review_country == 'Mexico' ? 'selected' : ''; ?>>Mexico</option>
                                    <option value="Micronesia, Federated States of" <?php echo $trip_review->review_country == 'Micronesia, Federated States of' ? 'selected' : ''; ?>>Micronesia, Federated States of</option>
                                    <option value="Moldova, Republic of" <?php echo $trip_review->review_country == 'Moldova, Republic of' ? 'selected' : ''; ?>>Moldova, Republic of</option>
                                    <option value="Monaco" <?php echo $trip_review->review_country == 'Monaco' ? 'selected' : ''; ?>>Monaco</option>
                                    <option value="Mongolia" <?php echo $trip_review->review_country == 'Mongolia' ? 'selected' : ''; ?>>Mongolia</option>
                                    <option value="Montenegro" <?php echo $trip_review->review_country == 'Montenegro' ? 'selected' : ''; ?>>Montenegro</option>
                                    <option value="Montserrat" <?php echo $trip_review->review_country == 'Montserrat' ? 'selected' : ''; ?>>Montserrat</option>
                                    <option value="Morocco" <?php echo $trip_review->review_country == 'Morocco' ? 'selected' : ''; ?>>Morocco</option>
                                    <option value="Mozambique" <?php echo $trip_review->review_country == 'Mozambique' ? 'selected' : ''; ?>>Mozambique</option>
                                    <option value="Myanmar" <?php echo $trip_review->review_country == 'Myanmar' ? 'selected' : ''; ?>>Myanmar</option>
                                    <option value="Namibia" <?php echo $trip_review->review_country == 'Namibia' ? 'selected' : ''; ?>>Namibia</option>
                                    <option value="Nauru" <?php echo $trip_review->review_country == 'Nauru' ? 'selected' : ''; ?>>Nauru</option>
                                    <option value="Nepal" <?php echo $trip_review->review_country == 'Nepal' ? 'selected' : ''; ?>>Nepal</option>
                                    <option value="Netherlands" <?php echo $trip_review->review_country == 'Netherlands' ? 'selected' : ''; ?>>Netherlands</option>
                                    <option value="Netherlands Antilles" <?php echo $trip_review->review_country == 'Netherlands Antilles' ? 'selected' : ''; ?>>Netherlands Antilles</option>
                                    <option value="New Caledonia" <?php echo $trip_review->review_country == 'New Caledonia' ? 'selected' : ''; ?>>New Caledonia</option>
                                    <option value="New Zealand" <?php echo $trip_review->review_country == 'New Zealand' ? 'selected' : ''; ?>>New Zealand</option>
                                    <option value="Nicaragua" <?php echo $trip_review->review_country == 'Nicaragua' ? 'selected' : ''; ?>>Nicaragua</option>
                                    <option value="Niger" <?php echo $trip_review->review_country == 'Niger' ? 'selected' : ''; ?>>Niger</option>
                                    <option value="Nigeria" <?php echo $trip_review->review_country == 'Nigeria' ? 'selected' : ''; ?>>Nigeria</option>
                                    <option value="Niue" <?php echo $trip_review->review_country == 'Niue' ? 'selected' : ''; ?>>Niue</option>
                                    <option value="Norfolk Island" <?php echo $trip_review->review_country == 'Norfolk Island' ? 'selected' : ''; ?>>Norfolk Island</option>
                                    <option value="Northern Mariana Islands" <?php echo $trip_review->review_country == 'Northern Mariana Islands' ? 'selected' : ''; ?>>Northern Mariana Islands</option>
                                    <option value="Norway" <?php echo $trip_review->review_country == 'Norway' ? 'selected' : ''; ?>>Norway</option>
                                    <option value="Oman" <?php echo $trip_review->review_country == 'Oman' ? 'selected' : ''; ?>>Oman</option>
                                    <option value="Pakistan" <?php echo $trip_review->review_country == 'Pakistan' ? 'selected' : ''; ?>>Pakistan</option>
                                    <option value="Palau" <?php echo $trip_review->review_country == 'Palau' ? 'selected' : ''; ?>>Palau</option>
                                    <option value="Palestinian Territory, Occupied" <?php echo $trip_review->review_country == 'Palestinian Territory, Occupied' ? 'selected' : ''; ?>>Palestinian Territory, Occupied</option>
                                    <option value="Panama" <?php echo $trip_review->review_country == 'Panama' ? 'selected' : ''; ?>>Panama</option>
                                    <option value="Papua New Guinea" <?php echo $trip_review->review_country == 'Papua New Guinea' ? 'selected' : ''; ?>>Papua New Guinea</option>
                                    <option value="Paraguay" <?php echo $trip_review->review_country == 'Paraguay' ? 'selected' : ''; ?>>Paraguay</option>
                                    <option value="Peru" <?php echo $trip_review->review_country == 'Peru' ? 'selected' : ''; ?>>Peru</option>
                                    <option value="Philippines" <?php echo $trip_review->review_country == 'Philippines' ? 'selected' : ''; ?>>Philippines</option>
                                    <option value="Pitcairn" <?php echo $trip_review->review_country == 'Pitcairn' ? 'selected' : ''; ?>>Pitcairn</option>
                                    <option value="Poland" <?php echo $trip_review->review_country == 'Poland' ? 'selected' : ''; ?>>Poland</option>
                                    <option value="Portugal" <?php echo $trip_review->review_country == 'Portugal' ? 'selected' : ''; ?>>Portugal</option>
                                    <option value="Puerto Rico" <?php echo $trip_review->review_country == 'Puerto Rico' ? 'selected' : ''; ?>>Puerto Rico</option>
                                    <option value="Qatar" <?php echo $trip_review->review_country == 'Qatar' ? 'selected' : ''; ?>>Qatar</option>
                                    <option value="Reunion" <?php echo $trip_review->review_country == 'Reunion' ? 'selected' : ''; ?>>Reunion</option>
                                    <option value="Romania" <?php echo $trip_review->review_country == 'Romania' ? 'selected' : ''; ?>>Romania</option>
                                    <option value="Russian Federation" <?php echo $trip_review->review_country == 'Russian Federation' ? 'selected' : ''; ?>>Russian Federation</option>
                                    <option value="Rwanda" <?php echo $trip_review->review_country == 'Rwanda' ? 'selected' : ''; ?>>Rwanda</option>
                                    <option value="Saint Helena" <?php echo $trip_review->review_country == 'Saint Helena' ? 'selected' : ''; ?>>Saint Helena</option>
                                    <option value="Saint Kitts and Nevis" <?php echo $trip_review->review_country == 'Saint Kitts and Nevis' ? 'selected' : ''; ?>>Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia" <?php echo $trip_review->review_country == 'Saint Lucia' ? 'selected' : ''; ?>>Saint Lucia</option>
                                    <option value="Saint Pierre and Miquelon" <?php echo $trip_review->review_country == 'Saint Pierre and Miquelon' ? 'selected' : ''; ?>>Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and The Grenadines" <?php echo $trip_review->review_country == 'Saint Vincent and The Grenadines' ? 'selected' : ''; ?>>Saint Vincent and The Grenadines</option>
                                    <option value="Samoa" <?php echo $trip_review->review_country == 'Samoa' ? 'selected' : ''; ?>>Samoa</option>
                                    <option value="San Marino" <?php echo $trip_review->review_country == 'San Marino' ? 'selected' : ''; ?>>San Marino</option>
                                    <option value="Sao Tome and Principe" <?php echo $trip_review->review_country == 'Sao Tome and Principe' ? 'selected' : ''; ?>>Sao Tome and Principe</option>
                                    <option value="Saudi Arabia" <?php echo $trip_review->review_country == 'Saudi Arabia' ? 'selected' : ''; ?>>Saudi Arabia</option>
                                    <option value="Senegal" <?php echo $trip_review->review_country == 'Senegal' ? 'selected' : ''; ?>>Senegal</option>
                                    <option value="Serbia" <?php echo $trip_review->review_country == 'Serbia' ? 'selected' : ''; ?>>Serbia</option>
                                    <option value="Seychelles" <?php echo $trip_review->review_country == 'Seychelles' ? 'selected' : ''; ?>>Seychelles</option>
                                    <option value="Sierra Leone" <?php echo $trip_review->review_country == 'Sierra Leone' ? 'selected' : ''; ?>>Sierra Leone</option>
                                    <option value="Singapore" <?php echo $trip_review->review_country == 'Singapore' ? 'selected' : ''; ?>>Singapore</option>
                                    <option value="Slovakia" <?php echo $trip_review->review_country == 'Slovakia' ? 'selected' : ''; ?>>Slovakia</option>
                                    <option value="Slovenia" <?php echo $trip_review->review_country == 'Slovenia' ? 'selected' : ''; ?>>Slovenia</option>
                                    <option value="Solomon Islands" <?php echo $trip_review->review_country == 'Solomon Islands' ? 'selected' : ''; ?>>Solomon Islands</option>
                                    <option value="Somalia" <?php echo $trip_review->review_country == 'Somalia' ? 'selected' : ''; ?>>Somalia</option>
                                    <option value="South Africa" <?php echo $trip_review->review_country == 'South Africa' ? 'selected' : ''; ?>>South Africa</option>
                                    <option value="South Georgia and The South Sandwich Islands" <?php echo $trip_review->review_country == 'South Georgia and The South Sandwich Islands' ? 'selected' : ''; ?>>South Georgia and The South Sandwich Islands</option>
                                    <option value="Spain" <?php echo $trip_review->review_country == 'Spain' ? 'selected' : ''; ?>>Spain</option>
                                    <option value="Sri Lanka" <?php echo $trip_review->review_country == 'Sri Lanka' ? 'selected' : ''; ?>>Sri Lanka</option>
                                    <option value="Sudan" <?php echo $trip_review->review_country == 'Sudan' ? 'selected' : ''; ?>>Sudan</option>
                                    <option value="Suriname" <?php echo $trip_review->review_country == 'Suriname' ? 'selected' : ''; ?>>Suriname</option>
                                    <option value="Svalbard and Jan Mayen" <?php echo $trip_review->review_country == 'Svalbard and Jan Mayen' ? 'selected' : ''; ?>>Svalbard and Jan Mayen</option>
                                    <option value="Swaziland" <?php echo $trip_review->review_country == 'Swaziland' ? 'selected' : ''; ?>>Swaziland</option>
                                    <option value="Sweden" <?php echo $trip_review->review_country == 'Sweden' ? 'selected' : ''; ?>>Sweden</option>
                                    <option value="Switzerland" <?php echo $trip_review->review_country == 'Switzerland' ? 'selected' : ''; ?>>Switzerland</option>
                                    <option value="Syrian Arab Republic" <?php echo $trip_review->review_country == 'Syrian Arab Republic' ? 'selected' : ''; ?>>Syrian Arab Republic</option>
                                    <option value="Taiwan, Province of China" <?php echo $trip_review->review_country == 'Taiwan, Province of China' ? 'selected' : ''; ?>>Taiwan, Province of China</option>
                                    <option value="Tajikistan" <?php echo $trip_review->review_country == 'Tajikistan' ? 'selected' : ''; ?>>Tajikistan</option>
                                    <option value="Tanzania, United Republic of" <?php echo $trip_review->review_country == 'Tanzania, United Republic of' ? 'selected' : ''; ?>>Tanzania, United Republic of</option>
                                    <option value="Thailand" <?php echo $trip_review->review_country == 'Thailand' ? 'selected' : ''; ?>>Thailand</option>
                                    <option value="Timor-leste" <?php echo $trip_review->review_country == 'Timor-leste' ? 'selected' : ''; ?>>Timor-leste</option>
                                    <option value="Togo" <?php echo $trip_review->review_country == 'Togo' ? 'selected' : ''; ?>>Togo</option>
                                    <option value="Tokelau" <?php echo $trip_review->review_country == 'Tokelau' ? 'selected' : ''; ?>>Tokelau</option>
                                    <option value="Tonga" <?php echo $trip_review->review_country == 'Tonga' ? 'selected' : ''; ?>>Tonga</option>
                                    <option value="Trinidad and Tobago" <?php echo $trip_review->review_country == 'Trinidad and Tobago' ? 'selected' : ''; ?>>Trinidad and Tobago</option>
                                    <option value="Tunisia" <?php echo $trip_review->review_country == 'Tunisia' ? 'selected' : ''; ?>>Tunisia</option>
                                    <option value="Turkey" <?php echo $trip_review->review_country == 'Turkey' ? 'selected' : ''; ?>>Turkey</option>
                                    <option value="Turkmenistan" <?php echo $trip_review->review_country == 'Turkmenistan' ? 'selected' : ''; ?>>Turkmenistan</option>
                                    <option value="Turks and Caicos Islands" <?php echo $trip_review->review_country == 'Turks and Caicos Islands' ? 'selected' : ''; ?>>Turks and Caicos Islands</option>
                                    <option value="Tuvalu" <?php echo $trip_review->review_country == 'Tuvalu' ? 'selected' : ''; ?>>Tuvalu</option>
                                    <option value="Uganda" <?php echo $trip_review->review_country == 'Uganda' ? 'selected' : ''; ?>>Uganda</option>
                                    <option value="Ukraine" <?php echo $trip_review->review_country == 'Ukraine' ? 'selected' : ''; ?>>Ukraine</option>
                                    <option value="United Arab Emirates" <?php echo $trip_review->review_country == 'United Arab Emirates' ? 'selected' : ''; ?>>United Arab Emirates</option>
                                    <option value="United Kingdom" <?php echo $trip_review->review_country == 'United Kingdom' ? 'selected' : ''; ?>>United Kingdom</option>
                                    <option value="United States" <?php echo $trip_review->review_country == 'United States' ? 'selected' : ''; ?>>United States</option>
                                    <option value="United States Minor Outlying Islands" <?php echo $trip_review->review_country == 'United States Minor Outlying Islands' ? 'selected' : ''; ?>>United States Minor Outlying Islands</option>
                                    <option value="Uruguay" <?php echo $trip_review->review_country == 'Uruguay' ? 'selected' : ''; ?>>Uruguay</option>
                                    <option value="Uzbekistan" <?php echo $trip_review->review_country == 'Uzbekistan' ? 'selected' : ''; ?>>Uzbekistan</option>
                                    <option value="Vanuatu" <?php echo $trip_review->review_country == 'Vanuatu' ? 'selected' : ''; ?>>Vanuatu</option>
                                    <option value="Venezuela" <?php echo $trip_review->review_country == 'Venezuela' ? 'selected' : ''; ?>>Venezuela</option>
                                    <option value="Viet Nam" <?php echo $trip_review->review_country == 'Viet Nam' ? 'selected' : ''; ?>>Viet Nam</option>
                                    <option value="Virgin Islands, British" <?php echo $trip_review->review_country == 'Virgin Islands, British' ? 'selected' : ''; ?>>Virgin Islands, British</option>
                                    <option value="Virgin Islands, U.S." <?php echo $trip_review->review_country == 'Virgin Islands, U.S.' ? 'selected' : ''; ?>>Virgin Islands, U.S.</option>
                                    <option value="Wallis and Futuna" <?php echo $trip_review->review_country == 'Wallis and Futuna' ? 'selected' : ''; ?>>Wallis and Futuna</option>
                                    <option value="Western Sahara" <?php echo $trip_review->review_country == 'Western Sahara' ? 'selected' : ''; ?>>Western Sahara</option>
                                    <option value="Yemen" <?php echo $trip_review->review_country == 'Yemen' ? 'selected' : ''; ?>>Yemen</option>
                                    <option value="Zambia" <?php echo $trip_review->review_country == 'Zambia' ? 'selected' : ''; ?>>Zambia</option>
                                    <option value="Zimbabwe" <?php echo $trip_review->review_country == 'Zimbabwe' ? 'selected' : ''; ?>>Zimbabwe</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Reviewer Image</label>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="mb-3">
                                            <img id="cropper-image"
                                                 class="crop-img-div"
                                                 src="{{ $trip_review->image_url }}">
                                        </div>
                                        <input type="file"
                                               name="file"
                                               id="cropper-upload">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Review</label>
                                <textarea name="review"
                                          id=""
                                          cols="30"
                                          rows="10"
                                          class="form-control">{{ $trip_review->review }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Rating</label>
                                <div>
                                    <input type="hidden"
                                           id="trip-rating"
                                           name="rating"
                                           class="rating"
                                           value="{{ $trip_review->rating }}"
                                           data-filled="fas fa-star fa-2x"
                                           data-empty="far fa-star fa-2x" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-check-mark"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="./assets/vendors/bootstrap-rating-master/bootstrap-rating.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#trip-rating").rating();
            $("#add-form-page").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
                    handleRegionForm(form);
                }
            });
            var cropped = false;
            const image = document.getElementById('cropper-image');
            var cropper = "";

            function handleRegionForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);
                if (cropper) {
                    formData.append('cropped_data', JSON.stringify(cropper.getData()));
                }

                $.ajax({
                    url: "{{ route('admin.trip-reviews.update') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = '{{ route('admin.trip-reviews.index') }}';
                        }
                    }
                });
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#cropper-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#cropper-upload").change(function() {
                readURL(this);
            });
        });
    </script>
@endpush
