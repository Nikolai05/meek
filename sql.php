<<?php  INSERT INTO `customer` (`OrderID`, `OrderNumber`, `CustName`, `Country`, `Address1`, `Address2`, `City`, `Province`, `Zip`, `Phone`, `FinancialStatus`, `Storename`)

 VALUES ('5666943367', '2667', 'jeremy daby', 'United States', '471 Mundet Pl', 'Ste US227349', 'Hillside', 'New Jersey', '7205', '', 'Refunded', 'gearforyou'),
        ('5673473799', '2668', 'Joshua McFalls', 'United States', '610 Beach Ave', '1', 'Marysville', 'Washington', '98270', '', 'Paid', 'gearforyou'),
        ('5639906900', '54923', 'Nicholas Floyd', 'United States', '9750 Indiana Pkwy', '', 'Munster', 'Indiana', '46321', '', 'Paid', 'mymobile-gear'),
        ('5639911956', '54924', 'Alberto Becker M', 'México', 'Av. Lomas Anahuac 133', '1602-G', 'Edo. de Mexico', 'Mexico', '52760', '', 'Paid', 'mymobile-gear'),
        ('5639918612', '54925', 'Marek Luckos', 'United States', '705 Western St', '', 'Hoffman Est', 'Illinois', '60169-3026', '', 'Paid', 'mymobile-gear'),
        ('5639921428', '54926', 'rodrigo bastos', 'Brazil', 'Avenida Alfredo Balthazar da Silveira  339  1806 coral bali', 'Recreio dos Bandeirantes', 'Rio de Janeiro', 'Rio de Janeiro', '22790-710', '', 'Paid', 'mymobile-gear'),
        ('5595451655', '1097', 'romulo cuevas', 'United States', '8298 NW 68th St', 'DO YA-365', 'Miami', 'Florida', '33166', '+1 786-817-2108', 'Pending', 'kittenlovers'),
        ('5595465095', '1098', 'romulo cuevas', 'United States', '8298 NW 68th St', 'DO YA-365', 'Miami', 'Florida', '33166', '+1 786-817-2108', 'Pending', 'kittenlovers'),
        ('5611138247', '1099', 'Carlo  Moran', 'Philippines', 'Lot 24 blk 1Basswood street, Greenwoods Executive Village, San Andres', '', 'Cainta, Rizal', '', '1900', '+63 917 528 2988', 'Paid', 'kittenlovers'),
        ('5095721220', '1273', 'jeon ju-sung', 'South Korea', '고산로12-2', '푸른빌 A동 304호', '서구', 'Incheon', '22625', '821052480921', 'Paid', '4xhome'),
        ('5096126980', '1274', 'Dorvalino Borgea', 'Canada', '59millicent st', '', 'Toronto', 'Toronto', 'M6H1W3', '', 'Paid', '4xhome'),
        ('5101370308', '1275', 'Prashant  Mukhia', 'India', 'Panighatta Ord Tea Garden', '', 'Siliguri', 'West Bengal', '', '787 232 6650', 'Paid', '4xhome'),
        ('5499788743', '1275', 'Mario Enrique Peña Cuanda', 'Mexico', 'Alfonso Esparza Oteo 152 col. Guadalupe Inn', '', 'Del. Álvaro Obregón', 'Distrito Federal', '01020', '', 'Paid', '4xhome');
?>








<?

UPDATE `lineitems` SET `Sku` = '3762621-pink' WHERE `lineitems`.`Sku` = 6;

SELECT customer.OrderNumber, customer.CustName, lineitems.Qty, product.ProductName, store.Storename
FROM customer,lineitems, product, store
WHERE customer.OrderNumber='1275' AND customer.OrderID = lineitems.OrderID AND product.Sku = lineitems.Sku AND customer.StoreID=store.storeID



SELECT *
FROM customer,lineitems, product, store, batch
WHERE customer.OrderID = lineitems.OrderID AND product.Sku = lineitems.Sku AND customer.StoreName=store.StoreName AND lineitems.BatchID = batch.BatchID


?>
