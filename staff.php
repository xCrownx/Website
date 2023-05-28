<?php include('./inc/header.php'); ?>
<h1>Madness Flyff Staff Team</h1>
<div class="site">
    <div class="slideshow">
        <?php
        $admins = array(
            array(
                'image' => "../img/admin1.jpg",
                'name' => "Bodo"
            ),
            array(
                'image' => "../img/admin2.jpg",
                'name' => "Jerome"
            ),
            array(
                'image' => "../img/admin3.jpg",
                'name' => "Silent"
            )
        );
        $targetWidth = 400;
        $targetHeight = 250;
        foreach ($admins as $admin) {
            $imagePath = "img/" . $admin['image'];
            $resizedImage = resizeImage($imagePath, $targetWidth, $targetHeight);
            echo '<div class="slide">';
            echo '<img src="' . $resizedImage . '" alt="Administrator" class="slide-image" />';
            echo '<span class="slide-name">' . $admin['name'] . '</span>';
            echo '</div>';
        }

        function resizeImage($imagePath, $targetWidth, $targetHeight) {
            list($sourceWidth, $sourceHeight) = getimagesize($imagePath);
            $sourceAspectRatio = $sourceWidth / $sourceHeight;
            $targetAspectRatio = $targetWidth / $targetHeight;

            $resizeWidth = $targetWidth;
            $resizeHeight = $targetHeight;

            if ($sourceAspectRatio > $targetAspectRatio) {
                $resizeHeight = $targetWidth / $sourceAspectRatio;
            } else {
                $resizeWidth = $targetHeight * $sourceAspectRatio;
            }

            $resizedImage = imagecreatetruecolor($resizeWidth, $resizeHeight);
            $sourceImage = imagecreatefromjpeg($imagePath);
            imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $sourceWidth, $sourceHeight);

            $outputPath = "img/" . basename($imagePath);
            imagejpeg($resizedImage, $outputPath);

            imagedestroy($resizedImage);
            imagedestroy($sourceImage);

            return $outputPath;
        }
        ?>
    </div>
    <div class="additional-images">
        <?php
        $additionalAdmins = array(
            array(
                'image' => "../img/admin4.jpg",
                'name' => "John"
            ),
            array(
                'image' => "../img/admin5.jpg",
                'name' => "Jane"
            ),
            array(
                'image' => "../img/admin6.jpg",
                'name' => "Mike"
            )
        );

        foreach ($additionalAdmins as $admin) {
            $imagePath = "img/" . $admin['image'];
            $resizedImage = resizeImage($imagePath, $targetWidth, $targetHeight);
            echo '<div class="additional-slide">';
            echo '<img src="' . $resizedImage . '" alt="Administrator" class="additional-slide-image" />';
            echo '<span class="additional-slide-name">' . $admin['name'] . '</span>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<?php include('./inc/footer.php'); ?>
