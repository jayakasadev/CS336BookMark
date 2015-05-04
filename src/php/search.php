 
 <form  action="search.php">
 search:<input type="text" name="q" />
sort by:<select name="sort">
 <option value="price" > price </option>
 <option value="title"> title </option>
 <option value="date" > date </option>
 <option value="rank" > seller rank </option>
 <option value="school" > school with most results </option>
 </select>university:
 <select name="university">
 <option value="">all</option>
 <?php include("hello.php");
 $stmt = $conn->prepare("SELECT U.universityid, U.universityname FROM University U");
        $stmt->execute();
$stmt->bind_result($universityid, $universityname);
while( $stmt->fetch()) {

echo "<option value=\"".$universityid."\">". $universityname."</option><br>";


}
?>
 </select>
 
 <input type="submit" value="submit" />
 </form>
 <?php 


echo "Items for sale:<br>";
$sort="title";
if (isset ($_GET["sort"])){ if ($_GET["sort"] == "title"){$sort ="title";} else if ($_GET["sort"]=="date"){$sort="date";}else if($_GET["sort"]=="price"){ $sort="price";}else if ($_GET["sort"]=="rank"){$sort="rank";}else if($_GET["sort"]=="school" && $_GET["university"]==''){$sort="school";}}
$search="%%";
$start=0;
$university='';
echo "search for: ";
if (isset ($_GET["q"]) ){ $search='%'.$_GET["q"].'%'; $_GET["q"]." ";}
if (isset ($_GET["start"])){$start=$_GET["start"];}
if (isset ($_GET["university"])){$university=$_GET["university"];}
echo "sorted by:".$sort." ";
$title; $price; $itemowner; $itemid; $date; $rank; $seller;$universityname="";
if ($sort=="rank"){
if ($university != ''){
$stmt = $conn->prepare("SELECT L.title, L.price, L.itemowner, L.itemid, L.date, slist.rank, slist.seller FROM

((SELECT T.seller AS seller, COUNT(*) AS rank FROM

Transaction T

GROUP BY T.seller)UNION

(SELECT L.itemowner AS seller, 0 AS rank FROM Item L

LEFT JOIN Transaction T ON

T.seller = L.itemowner

WHERE T.seller IS NULL

GROUP BY L.itemowner)

) AS slist,

Item L, User U

WHERE L.itemowner=slist.seller AND (L.status='listed' OR L.status='pending') AND L.title LIKE ?  AND U.username=slist.seller AND U.universityid=?

ORDER BY (slist.rank) DESC, slist.seller DESC LIMIT ?,10");

$stmt->bind_param("sii",$search, $university,$start);
$stmt->execute();
$stmt->bind_result($title, $price, $itemowner, $itemid, $date, $rank, $seller);
}else{
$stmt = $conn->prepare("SELECT L.title, L.price, L.itemowner, L.itemid, L.date, slist.rank, slist.seller FROM

((SELECT T.seller AS seller, COUNT(*) AS rank FROM

Transaction T

GROUP BY T.seller)UNION

(SELECT L.itemowner AS seller, 0 AS rank FROM Item L

LEFT JOIN Transaction T ON

T.seller = L.itemowner

WHERE T.seller IS NULL

GROUP BY L.itemowner)

) AS slist,

Item L

WHERE L.itemowner=slist.seller AND (L.status='listed' OR L.status='pending') AND L.title LIKE ?  

ORDER BY (slist.rank) DESC, slist.seller DESC LIMIT ?,10");

$stmt->bind_param("si",$search, $start);
$stmt->execute();
$stmt->bind_result($title, $price, $itemowner, $itemid, $date, $rank, $seller);




}


}else if (($sort=="school") ){

$stmt = $conn->prepare("SELECT L.title, L.price, L.itemowner, L.itemid, L.date, slist.rank, C.universityname FROM
(SELECT COUNT(*) as rank, U.universityid FROM
 User U, Item L
WHERE L.itemowner=U.username AND (L.status='listed' OR L.status='pending') AND L.title LIKE ?
GROUP BY U.universityid) as slist,
Item L,
User U,
University C
WHERE 
L.itemowner=U.username AND U.universityid=slist.universityid AND C.universityid=slist.universityid  AND (L.status='listed' OR L.status='pending') AND L.title LIKE ?
ORDER BY (slist.rank) DESC, C.universityname DESC LIMIT ?,10");

$stmt->bind_param("ssi",$search, $search, $start);
$stmt->execute();
$stmt->bind_result($title, $price, $itemowner, $itemid, $date, $rank, $universityname);
}else{

if ($university != ''){
$stmt = $conn->prepare("SELECT U.title, U.itemid, U.price, U.date FROM Item  U, User S WHERE (U.status='listed' OR U.status='pending') AND U.title LIKE ?  AND U.itemowner=S.username AND S.universityid=? ORDER BY ".$sort." LIMIT ?, 10");

$stmt->bind_param("sii",$search,$university,$start);
$stmt->execute();
$stmt->bind_result($title, $itemid, $price, $date);
}else{
$stmt = $conn->prepare("SELECT U.title, U.itemid, U.price, U.date, C.universityname FROM Item  U, User S, University C WHERE U.itemowner=S.username AND S.universityid=C.universityid AND(U.status='listed' OR U.status='pending') AND U.title LIKE ?  ORDER BY ".$sort." LIMIT ?, 10");
$stmt->bind_param("si",$search,$start);
$stmt->execute();
$stmt->bind_result($title, $itemid, $price, $date, $universityname);
}
}


//echo "number of results".$result->num_rows."<br>";
$_SESSION["start"]=$start;
echo $stmt->error;
echo "<table>";
while( $stmt->fetch()) {

echo "<tr><td><a href=\"detailed.php?id=".$itemid."\">". $title."</a></td><td>".$price.'</td>&nbsp<td>'. $date. "</td>";

if (isset($seller)){echo "<td>".$seller."</td>";}
if (isset($universityname)){echo "<td>".$universityname."</td>"; if (isset($rank)){ echo "<td>".$rank."</td>";}}


echo"</tr>";


}
echo "</table>";
echo "<a href=\"search.php?id=".$search."&sort=".$sort."&start=".($_SESSION["start"]-10)."\">prev</a> &nbsp; &nbsp;";
echo "<a href=\"search.php?id=".$search."&sort=".$sort."&start=".($_SESSION["start"]+10)."\">next</a><br>";
echo "<a href=\"/home.php\"> my home page </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";


?>