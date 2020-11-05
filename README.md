# shhan
php로 만드는 쇼핑몰기본.
#개발환경

ide: newbeans 12.0
db: mariaDB
sql: mysql
언어: php 7.0

개발패키지: xampp

검색결과를 유지하면서 페이징처리하기.

$sql_search = " where mb_level IN ('1','3') AND mb_leave_date='' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel' :
        case 'mb_hp' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}
