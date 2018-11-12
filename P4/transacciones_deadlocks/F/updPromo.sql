/*B*/
alter table customers add promo numeric; 
update customers set promo=0;

/*C*/
create or replace FUNCTION updPromo() RETURNS TRIGGER AS $$
BEGIN

    UPDATE orderdetail 
	SET price = round( price + ((price*(old.promo/100))-(price*(new.promo/100)))::numeric,2)
    from orders
    where orderdetail.orderid in (select orders.orderid from orders where orders.customerid = new.customerid and status is null);
	
	return null;
END;
$$ LANGUAGE plpgsql;

drop trigger t_updPromos on customers;
create trigger t_updPromos after update on customers FOR EACH ROW 
when (old.promo is distinct from new.promo)
EXECUTE procedure updPromo();





insert into orders values (1000045, now(), 250, 15,5, 27.90,null);
insert into orderdetail values (1000045, 33, 10,1);
insert into orderdetail values (1000045, 32, 3,1);
insert into orderdetail values (1000045, 31, 12,1);
insert into orderdetail values (1000045, 36, 30,1);
insert into orderdetail values (1000045, 37, 8,1);
insert into orders values (1000049, now(), 251, 78,3, 30.90,null);
insert into orderdetail values (1000049, 20, 10,1);
insert into orderdetail values (1000049, 14, 23,1);
insert into orderdetail values (1000049, 31, 12,1);
insert into orderdetail values (1000049, 56, 10,1);
insert into orderdetail values (1000049, 377, 81,1);




update customers set promo = 20 where customerid =251;

select * from customers where customerid = 251;

select * from orderdetail where orderid in (select orderid from orders where customerid = 250)

