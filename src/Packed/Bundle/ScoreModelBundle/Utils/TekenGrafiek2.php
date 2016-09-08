<?php
namespace Packed\Bundle\ScoreModelBundle\Utils;

include("pchart/class/pData.class.php");
include("pchart/class/pDraw.class.php");
include("pchart/class/pRadar.class.php");
include("pchart/class/pImage.class.php");

class TekenGrafiek {

    private $grafiek;

    public function getGrafiek(){
        return $this->grafiek;
    }

    public function __construct($resultaten, $naamOrg, $sectienamen){

        $MyData = new \pData();
        /* pChart library inclusions */

        //$resultaten = array(20, 30, 100, 50, 70, 80, 10, 100);
        //$naamOrg = "PACKED";
            /* Create and populate the pData object */

        $MyData->addPoints($resultaten,"Score");
        $MyData->setSerieDescription("Score","Application A");
        $MyData->setPalette("Score",array("R"=>157,"G"=>196,"B"=>22));

        /* Define the absissa serie */
        $MyData->addPoints($sectienamen,"Families");
        $MyData->setAbscissa("Families");

        /* Create the pChart object */
        $myPicture = new \pImage(1000,750,$MyData);
        $myPicture->drawGradientArea(0,0,1000,750,DIRECTION_VERTICAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>240,"EndG"=>240,"EndB"=>240,"Alpha"=>100));
        $myPicture->drawGradientArea(0,0,1000,20,DIRECTION_HORIZONTAL,array("StartR"=>30,"StartG"=>30,"StartB"=>30,"EndR"=>100,"EndG"=>100,"EndB"=>100,"Alpha"=>100));
        //$myPicture->drawLine(0,20,300,20,array("R"=>255,"G"=>255,"B"=>255));
        $RectangleSettings = array("R"=>180,"G"=>180,"B"=>180,"Alpha"=>100);

        // JJ hier border maken
        /* Add a border to the picture */
        //$myPicture->drawRectangle(0,0,750,500,array("R"=>0,"G"=>0,"B"=>0));

        /* Write the picture title */
        $myPicture->setFontProperties(array("FontName"=>"fonts/Silkscreen.ttf","FontSize"=>11));
        $myPicture->drawText(20,13,"Resultaten - $naamOrg (". date('d-m-Y') .")",array("R"=>255,"G"=>255,"B"=>255));

        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>20,"R"=>80,"G"=>80,"B"=>80));

        /* Enable shadow computing */
        $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

        /* Create the pRadar object */
        $SplitChart = new \pRadar();

        /* Draw a radar chart */
        $myPicture->setGraphArea(200,50,750,750);
        $Options = array("DrawPoly"=>TRUE,"WriteValues"=>TRUE,"ValueFontSize"=>13,"Layout"=>RADAR_LAYOUT_STAR, "LabelPos"=>RADAR_LABELS_HORIZONTAL, "BackgroundGradient"=>array("StartR"=>255,"StartG"=>0,"StartB"=>0,"StartAlpha"=>100,"EndR"=>0,"EndG"=>139,"EndB"=>69,"EndAlpha"=>50));
        $SplitChart->drawRadar($myPicture,$MyData,$Options);

        /* Render the picture (choose the best way) */
        //$myPicture->autoOutput("pictures/example.radar.values.png");


        $image = 'resultaten' . rand() . '.png';
        $myPicture->Render($image);

        $this->grafiek = $image;



    }
}