<?php
$points = array();

/*Set Points*/
/*A*/array_push($points,array(2,4));
/*B*/array_push($points,array(2,2));
/*C*/array_push($points,array(4,6));
/*D*/array_push($points,array(6,8));
/*D*/array_push($points,array(6,8));
/*D*/array_push($points,array(10,8));
/*D*/array_push($points,array(10,6));
/*D*/array_push($points,array(8,6));
/*D*/array_push($points,array(12,4));
/*D*/array_push($points,array(10,-2));
/*D*/array_push($points,array(4,-2));

$returnArray = array();
//getCombinations(count($points), 3, $returnArray);

if(pointInArea(array(11,6), $points)){
    echo 'true';
}else{
    echo 'false';
}

function pointInArea($point, $area){

    $combinations = array();
    getCombinations(count($area),3,$combinations);

    foreach ($combinations as $trianglePoints){

        $triangleLinePoints = array();
        getCombinations(count($trianglePoints), 2, $triangleLinePoints);

        $isInTriangle = false;
        foreach ($triangleLinePoints as $triangleLinePoint){
            $isInTriangle = true;
            /*LINEPOINT 1*/ $point1 = $area[$trianglePoints[$triangleLinePoint[0]]];
            /*LINEPOINT 2*/ $point2 = $area[$trianglePoints[$triangleLinePoint[1]]];
            /*NONLINEPOINT*/


            foreach ($trianglePoints as $a => $b){
                if(!in_array($a,$triangleLinePoint)){
                    $nonlinepoint = $a;
                    //break;
                };
            }
            $line = getLine($point1, $point2);

            ///print_r($line);
            //print_r($area[$trianglePoints[$nonlinepoint]]);


            if(comparePointToLine($area[$trianglePoints[$nonlinepoint]], $line)){
                if(!comparePointToLine($point, $line)){
                    $isInTriangle = false;
                    break;
                }
            }else{
                if(comparePointToLine($point, $line)){
                    $isInTriangle = false;
                    break;
                }
            }


        }

        if($isInTriangle){
            return true;
        }


    }
    return false;

}

function comparePointToLine($point, $line){

    if($point[0]*$line[0] + $point[1]*$line[1] < $line[2]){
        /*POINT HIGHER THAN LINE*/
        return true;
    }else{
        /*POINT LOWER THAN LINE*/
        return false;
    }

}

function getLine($p1, $p2){

    $egim_payda = $p1[0] - $p2[0];
    $egim_pay = $p1[1] - $p2[1];

    if($egim_payda == 0){
       return array(1, 0, $p1[0]);
    }else{
        $egim = $egim_pay / $egim_payda;
    }


    $sabit = $egim_payda*($p1[1] - $egim*$p1[0]);

    return array(-$egim_pay, $egim_payda, $sabit);
}

function getCombinations($points, $depth, &$returnArray = array() , $currentDepth = 0, $upperLoops = array(), $index = 0, $counter = null){

    if(!isset($counter)){
        $counter = gmp_fact($points)/(gmp_fact($depth)*gmp_fact($points-$depth));
    }

    for($i = 0; $i < $points; $i++){
            if($currentDepth == $depth-1){
                $upperLoops[$currentDepth] = $i + $index + $currentDepth;
                array_push($returnArray,$upperLoops);
                continue;
            }
            $upperLoops[$currentDepth] = $i + $index + $currentDepth;
            getCombinations($points - $i - 1, $depth ,$returnArray, $currentDepth + 1, $upperLoops, $index + $i, $counter);
        }

}
