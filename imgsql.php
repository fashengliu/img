<?php 
session_start();
ini_set("display_errors", 0);
////////////////////////////////////////////////////
$dbhost = 'localhost';				//������
$port = '3306';
$dbuser = 'root';					//���ݿ��û���
$dbpass = '123456';						//���ݿ�����
////////////////////////////////////////////////////

$temp = $_POST['DATA'];
$temp = explode('| |',$temp);//��ԭʼ����

if(count($temp)<4){
	exit('Error');
}
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $temp[2], $port);
if (!$con){
	echo mysqli_connect_error();
	exit;
}
mysqli_select_db($temp[2],$con);
mysqli_set_charset($con,"GB2312");
mysqli_query($con,"set names GB2312");//�����Լ��������ݿ�ı���
//$rand = $temp[0]*1020/2;//����ͻ���Ч����

if($temp[1]=='SQL'){//���ɾ������
	if(mysqli_query($con,$temp[3])==false){
		echo ('0');//����ʧ��
	}else{
		echo ('1');//���ĳɹ�
	}
	sql_close();
	exit;
}
if($temp[1]=='GUN'){//��ȡ��¼��
	$rs=mysqli_query($con,"select count(*) from ".$temp[3]." ".$temp[4]);
	$myrow = mysqli_fetch_array($rs);
	sql_close();
	echo ($myrow[0]);
	exit;
}
if($temp[1]=='UPD'){//���ɾ������
	if ($temp[3]=='i'){
		$sql = "INSERT INTO ".$temp[4]." (".$temp[5].") VALUES (".$temp[6].")";
	}elseif ($temp[3]=='d'){
		$sql = "DELETE FROM  ".$temp[4]." ".$temp[5];
	}elseif ($temp[3]=='u'){
		$sql = "UPDATE ".$temp[4]." SET ".$temp[5]." ".$temp[6];
	}
	if(mysqli_query($con,$sql)==false){
		echo ('0');//����ʧ��
	}else{
		echo ('1');//���ĳɹ�
	}
	sql_close();
	exit;
}
if($temp[1]=='QUE'){//��ѯ
	$sql="SELECT ".$temp[4]." FROM ".$temp[3]." ".$temp[5];//ִ��SQL
	$result = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_row($result))
	{
		foreach ($row as $a){
   		 $txt .= $a.'/';
		}
		$txt .= '<br>';
	}
	echo $txt;
	sql_close();
	exit;
}
function sql_close(){
	mysqli_close($con);
	return true;
}

?>