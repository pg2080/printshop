
        <?php
        session_start();
        if(isset($_GET['id']))
        {
            //dbconnection
            $con= mysqli_connect('localhost', 'root', '', 'printshop');
            require '../fpdf17/fpdf.php';
            
            $select="select tbl_cart.*,tbl_user.*,tbl_order.* from tbl_user inner join tbl_cart on tbl_cart.customerid=tbl_user.user_id inner join tbl_order on tbl_order.cartid=tbl_cart.cart_id where tbl_cart.cart_id='".$_GET['id']."'";
            $result= mysqli_query($con, $select);
            $row= mysqli_fetch_assoc($result);
            
            $pdf = new FPDF('P','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','BI',14);
            $pdf->Cell(130,5,'PRINT SHOP',0,0);
            $pdf->Cell(59,5,'INVOICE',0,1);
            $pdf->Ln();
            $pdf->SetFont('Arial','',12);
            //print shop info
            $pdf->Cell(130,5,'Phone [+91 9081315238]',0,0);
            $pdf->Cell(25,5,'Invoice id:',0,0);;
            $pdf->Cell(34,5,$row['order_id'],0,1);
            $pdf->Cell(130,5,'Phone [+91 9512596863]',0,1);
            $pdf->Cell(130,5,'visit us :www.printshop.com',0,1);
            $pdf->Cell(34,5,'',0,1);
            $pdf->Ln();
            
            $pdf->SetFont('Arial','BU',12);
            $pdf->Cell(20,5,'Bill To',0,1);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(35,5,'Customer Name :',0,0);
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(20,5,$row['firstname'].' '.$row['lastname'],0,1);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(35,5,'Phone No :',0,0);
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(20,5,$row['contactno'],0,1);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(35,5,'Email Id :',0,0);
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(20,5,$row['email'],0,1);
            $pdf->ln();
            $pdf->SetFont('Arial','BU',12);
            $pdf->Cell(10,5,'Product Details',0,1,'L');
            $pdf->Ln();
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(10,5,'#',1,0);
            $pdf->Cell(60,5,'Design',1,0);
            $pdf->Cell(30,5,'Project',1,0);
            $pdf->Cell(30,5,'Quantity',1,0);
            $pdf->Cell(30,5,'Price',1,0);
            $pdf->Cell(30,5,'Totalprice',1,1);
            $pdf->SetFont('Arial','',11);
            
            $select="select tbl_design.*,tbl_cartdetails.*,tbl_printdetails.ordername from tbl_design inner join tbl_cartdetails on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_printdetails on tbl_printdetails.print_id=tbl_cartdetails.printdetailsid inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid where tbl_cart.cart_id='".$_GET['id']."'";
            $re= mysqli_query($con, $select);
            $no=1;
            while ($r= mysqli_fetch_assoc($re))
            {
                $pdf->Cell(10,5,$no,1,0);
                $pdf->Cell(60,5,$r['designname'],1,0);
                $pdf->Cell(30,5,$r['ordername'],1,0);
                $pdf->Cell(30,5,$r['quantity'],1,0);
                $pdf->Cell(30,5,$r['price'],1,0);
                $pdf->Cell(30,5,$r['totalprice'],1,1);
                $no++;
            }
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(150,6,'',0,0);
            $pdf->Cell(40,6,'Total Amount :'.$row['totalamount'],1,1,'L');
            
            $pdf->setnextline(4);
            $pdf->SetFont('Arial','BU',12);
            $pdf->Cell(40,6,'Details',0,1);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,6,'Order Address :',0,0);
            $pdf->SetFont('Arial','',11.5);
            $pdf->Cell(130,6,$row['orderaddress'],0,1);
            
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,6,'Order Date :',0,0);
            $pdf->SetFont('Arial','',11.5);
            $pdf->Cell(130,6,$row['orderdate'],0,1);
            
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,6,'Status :',0,0);
            $pdf->SetFont('Arial','',11.5);
            if($row['status']=='P')
                $value='Pending';
            else if($row['status']=='Di')
                $value="In Designing";
            else if($row['status']=='Pr')
                $value="In Printing";
            else if($row['status']=='Ds')
                $value="Dispetched";
            else if($row['status']=='D')
                $value='Delivered';
            else
                $value='Cancel';
            $pdf->Cell(130,6,$value,0,1);
            
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,6,'Payment Method :',0,0);
            $pdf->SetFont('Arial','',11.5);
            if($row['paymenttype']=='cod')
                $value='cash on delivery';
            else
                $value='online payment';
            
            $pdf->Cell(130,6,$value,0,1);
            
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,6,'Payment status :',0,0);
            $pdf->SetFont('Arial','',11.5);
            if($row['paymentstatus']=='p')
                $value='Pending';
            else
                $value='complete';
            $pdf->Cell(130,6,$value,0,1);
            
            $pdf->SetFont('Arial','BIU',12);
            
            $pdf->setnextline(5);
            
            $pdf->Cell(200,6,'THANK YOU STAY SAFE STAY HOME',0,1,'C');
            $pdf->Output();   
        }           
        else
        {
            echo 'Oops!!';
        }
        ?>