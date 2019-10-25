<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <base href="{{ url('/') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
        <link rel="stylesheet" type="text/css" href="css/app.css?t=<?= time() ?>">
    </head>

    <body>
        <div class="plane" id='booking-window'>
            <div class="cockpit"><h1>Please select a seat</h1></div>

            <div class="exit exit--front fuselage"></div>
            <ol class="cabin fuselage">
                <?php
                    $rows = ['A','B','C','D','E','F'];
                    $columns = 10;

                    for ($i=1; $i <= $columns; $i++) { 
                        echo '<li><ol class="seats">';
                        foreach ($rows as $row) {
                            $seat_id = $i.$row;

                            $checked = in_array($seat_id,$today_booked) ? 'checked' : '';
                            echo '<li class="seat">
                                <input type="checkbox" id="'. $seat_id .'" value="'. $seat_id .'" '. $checked .' />
                                <label for="'. $seat_id .'">'. $seat_id .'</label>
                            </li>';
                        }
                        echo '</ol></li>';
                    }
                ?>
            </ol>
            <div class="exit exit--back fuselage"></div>
        </div>

        <div class="modal" id="model-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-modal">&times;</button>
                        <h4 class="modal-title">Enter Booking Details</h4>
                    </div>
                    <div class="modal-body">
                        <form id="booking-form">
                            <input type="hidden" name="seat_id" value="">

                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control">
                            </div>

                            <div class="booking-warning"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success book-now">Book Now</button>
                        <button type="button" class="btn btn-danger close-modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="model-cancel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-cmodal">&times;</button>
                        <h4 class="modal-title">Cancel Booking</h4>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Are you sure to cancel this booking</h5>
                        <form id="bookingc-form">
                            <input type="hidden" name="seat_id" value="">
                            <div class="bookingc-warning"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button type="button" class="btn btn-success book-cancel">Cancel Booking</button>
                            <button type="button" class="btn btn-danger close-cmodal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    <script type="text/javascript" src="js/app.js?t=<?= time() ?>"></script>
</html>