<a href="index.php?module=submissions&action=index&sortBy=dateAdded&direction=desc">Newest First</a>
|
<a href="index.php?module=submissions&action=index&sortBy=dateAdded&direction=asc">Oldest First</a>
|
<a href="index.php?module=submissions&action=index&sortBy=random">Random</a>
<ul>
    <?php foreach( $submissions as $submission ) {
        $body = $submission['body'];
        $dateadded = $submission['dateadded'];
        $id = $submission['id'];
        ?>
        <li>
            <?php include 'views/submissions/view.php' ?>    
            <br/>
            <a href="index.php?module=submissions&action=view&id=<?=$id?>">View</a>
        </li>
    <?php } ?>
</ul>
<?php
if($page>1) {
    echo "<a href=\"index.php?$urlSuffix&page=".($page-1)."\">Prev</a>";
}
if($page<$numPages) {
    echo "<a href=\"index.php?$urlSuffix&page=".($page+1)."\">Next</a>";
}
?>
