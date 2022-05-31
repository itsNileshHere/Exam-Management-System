<?php
$output .= $endofDiv;
$selectquery = $selqueryPaginate;
$query = mysqli_query($db, $selectquery);
$total_records = mysqli_num_rows($query);
$total_pages = ceil($total_records / $limit);
$output .= '<div class="float-right pt-2"><ul class="pagination pg-blue">';

if ($page > 1) {
    $previous = $page - 1;

    //First Page
    $output .= '<li class="page-item page-list">
                    <a class="page-link" id="1">
                        <span aria-hidden="true" class="fa fa-angle-double-left"></span>
                    </a>
                </li>';

    // Previous Page
    $output .= '<li class="page-item page-list">
                    <a class="page-link" id="' . $previous . '" label="Previous">
                        <span aria-hidden="true" class="fa fa-angle-left"></span>
                    </a>
                </li>';
}
// Page Loop
for ($i = 1; $i <= $total_pages; $i++) {
    $active_class = "";
    if ($i == $page) {
        $active_class = "active";
        $curr_page = $i;
    }
    $output .= '<li class="page-item ' . $active_class . '"><a class="page-link" id="' . $i . '">' . $i . '</a></li>';
}
if ($page < $total_pages) {
    $page++;

    // Next Page
    $output .= '<li class="page-item">
                    <a class="page-link" id="' . $page . '" label="Next">
                        <span aria-hidden="true" class="fa fa-angle-right"></span>
                    </a>
                </li>';

    // Last Page
    $output .= '<li class="page-item page-list">
                    <a class="page-link" id="' . $total_pages . '" label="Last Page">
                        <span aria-hidden="true" class="fa fa-angle-double-right" label="first_page"></span>
                    </a>
                </li>';
}
$output .= '</ul></div>';
echo $output;
?>