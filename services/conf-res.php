<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require_once "connect.php";

$user_id = $_SESSION['user_id'];
$event_id = $_GET['id'];
$num_places = $_POST['nbp'];
$reservation_date = date('Y-m-d');  

try {
    $mysqlclient->beginTransaction();

    $reservationQuery = "INSERT INTO reservations (user_id, event_id, num_places, reservation_date)
                        VALUES (:user_id, :event_id, :num_places, :reservation_date)";
    $res = $mysqlclient->prepare($reservationQuery);
    $res->execute([
        'user_id' => $user_id,
        'event_id' => $event_id,
        'num_places' => $num_places,
        'reservation_date' => $reservation_date
    ]);

    // Mise a jour des places disponibles 
    $updateEventQuery = "UPDATE events SET places_dispo = places_dispo - :num_places WHERE id = :event_id";
    $res = $mysqlclient->prepare($updateEventQuery);
    $res->execute([
        'num_places' => $num_places,
        'event_id' => $event_id
    ]);


    $eventQuery = "SELECT title, date FROM events WHERE id = :id";
    $res = $mysqlclient->prepare($eventQuery);
    $res->execute([':id' => $event_id]);
    $event = $res->fetch(PDO::FETCH_ASSOC);
    $event_name = $event['title'];
    $event_date = date('F j, Y', strtotime($event['date'])); 

    $mysqlclient->commit();

    // Send confirmation email
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = '---------------------';
    $mail->Password = '*********************';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->setFrom('event-reservation@events.com', 'Events Reservation');
    $mail->addAddress($_POST['email'], $_POST['name']);
    $mail->isHTML(true);
    $mail->Subject = 'Reservation Confirmation';
    $mail->Body = "
    <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f8f8f8;
                    color: #333;
                    padding: 20px;
                }
                h2 {
                    color: #0088a9;
                    font-size: 24px;
                    margin-bottom: 20px;
                }
                .content {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                }
                .content p {
                    line-height: 1.6;
                }
                .footer {
                    color: #888;
                    font-size: 0.9rem;
                    margin-top: 20px;
                }
                .button {
                    display: inline-block;
                    background-color: #0088a9;
                    color: #fff;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    margin-top: 15px;
                }
                .button:hover {
                    background-color: #006f88;
                }
            </style>
        </head>
        <body>
            <div class='content'>
                <h2>Your Reservation is Confirmed!</h2>
                <p>Dear <strong>{$_POST['name']}</strong>,</p>
                <p>We are happy to confirm your reservation for <strong>{$_POST['nbp']}</strong> seat(s) at our upcoming event: <strong>$event_name</strong>.</p>
                <p><strong>Event Date:</strong> $event_date</p>
                <p><strong>Reservation Date:</strong> $reservation_date</p>
                <p>We can't wait to see you there and hope you enjoy the experience!</p>
                <p>If you have any questions or need to make changes to your reservation, feel free to contact us.</p>
                <a href='../events' class='button'>Return to Events</a>
            </div>
            <div class='footer'>
                <p>&copy; 2024 Events Reservation | All Rights Reserved</p>
            </div>
        </body>
    </html>";
    $mail->AltBody = 'Thank you for reserving your spot at our event. We look forward to seeing you!';
    $mail->send();

    // message du succ
    echo "
    <div style='text-align: center; padding: 20px; background-color: #f0f8ff; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);'>
        <h2 style='color: #28a745;'>Reservation Confirmed!</h2>
        <p style='font-size: 1.2rem; color: #333;'>Your reservation for <strong>{$_POST['nbp']}</strong> seat(s) at the <strong>$event_name</strong> event has been successfully confirmed. The event is scheduled for <strong>$event_date</strong> and the reservation date is <strong>$reservation_date</strong>.</p>
        <p style='font-size: 1rem;'>A confirmation email has been sent to your inbox. Thank you for reserving your spot!</p>
        <a href='../events' style='background-color: #0088a9; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold;'>Return to Events</a>
    </div>";
} catch (Exception $e) {
    $mysqlclient->rollBack();
    echo "Error: {$e->getMessage()}";
}
?>
