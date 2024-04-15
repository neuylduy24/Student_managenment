<?php
if(!function_exists('createLink')){
    function createLink($data = []){
        // tạo đường link phân trang cho từng chức năng của hệ thống
        /* $data là mảng dữ liệu
        [
            'c'=> 'department',
            'm'=> 'index',
            'page'=> '{page}',
            'search' => $keyword
        ]
        */
        $linkPage='';
        foreach($data as $key => $value){
            $linkPage .= empty($linkPage) ? "?{$key}={$value}" : "&{$key}={$value}";
        }
        return APP_ROOT_PATH . $linkPage;
        //index.php?c=department&m=index&page={page}&search=
    }
}

// tạo hàm phân trang
if(!function_exists('paginattion')){
    function paginattion($link, $totalItems, $page = 1, $limit = LIMIT_ITEM_PAGE){
        // $link : đường link cần phân trang lấy từ hàm createLink
        // $totalItems : tổng số dòng dữ liệu cần phân trang
        // $page : trang hiện tại người dùng đang xem dữ liệu
        // $limit : số dòng dữ liệu cần xem trên 1 trang
        // trong MySQL - SQL Server có từ khóa LIMIT start, rows
        // start : vị trí dòng dữ liệu lấy trong database (dòng đầu tiên bắt đầu từ số 0)
        // rows : số dòng dữ liệu muốn lấy ra là bao nhiêu
        // đi tính tổng số trang 
        $totalPage = ceil($totalItems / $limit);
        // ceil :  làm tròn số trong php(làm tròn số lên)
        // giới hạn lại page
        if($page < 1){
            $page = 1;
        }elseif($page > $totalPage){
            $page = $totalPage;
        }
        $start = ($page - 1) * $limit;

        // đi xây dựng template phân trang bằng bootstrap
        $htmlPage = '';
        $htmlPage .= '<nav>';
        $htmlPage .= ' <ul class="pagination">';
        // xử lý button previous : quay về trang trước đó
        if($page > 1){
            $htmlPage .= '<li class="page-item">';
            $htmlPage .= '<a href="'.str_replace('{page}', $page-1, $link).'" class="page-link">Previous</a>';
            $htmlPage .= '</li>';
        }
        // xử lý các trang còn lại
        for($i = 1; $i <= $totalPage; $i++){
            if($i == $page){
                // thông báo cho người dùng biết đang ở trang nào
                $htmlPage .= '<li class="page-item active" aria-current="page">';
                $htmlPage .= '<a class="page-link">'.$page.'</a>';
                $htmlPage .= '</li>';
            }else{
                // các trang khác
                $htmlPage .= '<li class="page-item">';
                $htmlPage .= '<a href="'.str_replace('{page}', $i, $link).'" class="page-link">'.$i.'</a>';
                $htmlPage .= '</li>';
            }
        }
        // xử lý button next : sang trang tiếp theo
        if($page < $totalPage){
            $htmlPage .= '<li class="page-item">';
            $htmlPage .= '<a class="page-link" href="'.str_replace('{page}', $page+1, $link).'">Next</a>';
            $htmlPage .= '</li>';
        }

        $htmlPage .= ' </ul>';
        $htmlPage .= '</nav>';

        return[
            'start' => $start,
            'htmlPage' => $htmlPage
        ];
    }
}