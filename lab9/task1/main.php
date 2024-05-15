<?php
if (isset($_GET["submit"])) {
    $birthDate = $_GET["date"];
    $birthDateTime = new DateTime($birthDate);
    $currentDate = new DateTime();

    $dayOfTheWeek = date("N", strtotime($birthDate));
    $userAge = $currentDate->diff($birthDateTime)->y;

    $currentYear = $currentDate->format('Y');
    $birthMonthAndDay = $birthDateTime->format('m-d');
    $nextBirthday = new DateTime($currentYear . '-' . $birthMonthAndDay);

    if ($nextBirthday > $currentDate) {
        $nextBirthday = $nextBirthday->modify('+1 year');
    }

    $numberOfDaysToNextBirthday = $currentDate->diff($nextBirthday)->days;

    $daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $dayOfWeekName = $daysOfWeek[$dayOfTheWeek - 1];

    echo "Born on $birthDate.<br>
    The day of the week was $dayOfWeekName.<br>
    You are $userAge years old.<br>
    Your next birthday is in $numberOfDaysToNextBirthday days.";
}
?>
