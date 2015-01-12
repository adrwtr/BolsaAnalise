<?
$ds_chave = $_REQUEST['ds_chave'];
$ano = '2014';
$arrCotacoes = array();

// conecta
$objPDO = new PDO(
   'mysql:host=localhost;dbname=boil;',
   'moodle',
   'moodle'
 );


// carrega papeis
$query = 'select * from papeis order by ds_chave asc';
$objPDOStatement = $objPDO->prepare($query);
$objPDOStatement->execute();
$arrPapeis = $objPDOStatement->fetchAll(\PDO::FETCH_ASSOC);
$objPDOStatement->closeCursor();

function vl($a)
{
   echo var_dump($a);
}

// carrega cotacoes
if ( $ds_chave <> '' )
{
   // carrega papel
   $query_papel = 'select * from papeis where ds_chave=\''.$ds_chave.'\';';
   $objPDOStatement = $objPDO->prepare($query_papel);
   $objPDOStatement->execute();
   $arrPapel = $objPDOStatement->fetchAll(\PDO::FETCH_ASSOC);
   $objPDOStatement->closeCursor();

   // carrega cotacoes
   $query_cotacao = '
      select *, DATE_FORMAT( dt_cotacao, \'%U\' ) as semana from cotacoes where 
         cd_papel=\''.$arrPapel[0]['cd_papel'].'\'
      and
         Year(dt_cotacao) = \''. $ano .'\'
      order by 
         dt_cotacao asc
   ';   
   $objPDOStatement = $objPDO->prepare($query_cotacao);
   $objPDOStatement->execute();
   $arrCotacoes = $objPDOStatement->fetchAll(\PDO::FETCH_ASSOC);
   $objPDOStatement->closeCursor();
}

$query_noticias = '
   select 
      *,
      DATE_FORMAT( dt_noticia, \'%U\' ) as semana
   from 
      noticias 
   where
      Year(dt_noticia) = \''. $ano .'\'
   order by dt_noticia asc;
';
$objPDOStatement = $objPDO->prepare($query_noticias);
$objPDOStatement->execute();
$arrNoticias = $objPDOStatement->fetchAll(\PDO::FETCH_ASSOC);
$objPDOStatement->closeCursor();

?>
  
<html>
<head>
   <script src="externos/chartjs/Chart.js"></script>
   <script language="javascript">

   var data = {
       

   <?
   $valores = '[0,';
   $labels = '["0",';
   foreach ( $arrCotacoes as $cotacao_id => $cotacao_v )
   {
      $arrValores[] = $cotacao_v['vl_cotacao'];
      $valores .= $cotacao_v['vl_cotacao'] . ', ';      
      $labels .= '"'. $cotacao_v['semana'] . '",';      
   }
   $valores .= '0]';
   $labels .= '"0"]';
   $menor = min($arrValores);
   $maior = max($arrValores);
   ?> 

   labels: <? echo $labels; ?>,

   datasets: [
        {
            label: "",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: <? echo $valores; ?>
        }
    ]
};      
</script>
</head>
   <body>


   <!-- papeis -->
   <table>
      <? 
      foreach ($arrPapeis as $key => $value) 
      {
         ?>
         <tr>
         <td>
            <font size="1">
            <a href="index.php?ds_chave=<? echo $value['ds_chave']; ?>">
            <? echo substr($value['ds_chave'],0, 3); ?> - <? echo substr($value['ds_papel'], 0, 3); ?>
            </a>
            </font>
         </td>
         </tr>      
         <?
      }
      ?>      
   </table>


      <canvas id="myChart" width="950" height="400"></canvas>
         <script language="javascript">
             var ctx = document.getElementById("myChart").getContext("2d");

             var steps = new Number(<? echo $maior; ?>);

             var stepWidth = new Number(1);
            if (<? echo $maior; ?> > 10) {
               stepWidth = Math.floor(<? echo $maior; ?> / 10);
               steps = Math.ceil(<? echo $maior; ?> / stepWidth);
            }
            
            // var options = { scaleOverride: true, scaleSteps: steps, scaleStepWidth: stepWidth, scaleStartValue: 0 };

             var options = {
               scaleFontSize: 8,
               tooltipTitleFontSize: 8,
               scaleGridLineWidth : 2,
               pointDot : true,

               //Number - Radius of each point dot in pixels
               pointDotRadius : 2,

               //Number - Pixel width of point dot stroke
               pointDotStrokeWidth : 1,
               scaleOverride: true,
               scaleIntegersOnly: false,

               scaleSteps: steps, // <? echo ($maior+3)/2; ?>,
               // Number - The value jump in the hard coded scale
               scaleStepWidth: stepWidth,
               // Number - The scale starting value
               scaleStartValue: <? echo $menor-3; ?>

             };
             var myLineChart = new Chart(ctx).Line(data, options);
         </script>

<?
// organiza noticias x precos
foreach ($arrCotacoes as $cotacao_id => $cotacao_v) 
{
   foreach( $arrNoticias as $noticia_id => $noticia_v )
   {
      if ( $cotacao_v['semana'] == $noticia_v['semana'] )
      {         
         $arrCotacoes[$cotacao_id]['arrNoticia'][] = $noticia_v;
      }
   }
}
?>

   <table border="0" cellspacing="0" cellpadding="3">
      
      <?
      foreach ($arrCotacoes as $cotacao_id => $cotacao_v) 
      {      
         ?>         
         <tr>
         <td>
            <font size="1" face="verdana">
            <? echo $cotacao_v['vl_cotacao']; ?>            
            </font>
         </td>
         <td>
            <font size="1" face="verdana">
            <?
            if ( is_array($arrCotacoes[$cotacao_id]['arrNoticia']))
            {
               foreach( $arrCotacoes[$cotacao_id]['arrNoticia'] as $noticia_id => $noticia_v )
               {
                  echo $noticia_v['cd_noticia'] .' - '. $noticia_v['ds_titulo'] . ' - ' . $noticia_v['dt_noticia'] . '<BR>';
               }
            }
            ?>
            </font>
         </td>
         <td></td>
         </tr>
         <?
      }
      ?>
   </table>


</body>
</html>