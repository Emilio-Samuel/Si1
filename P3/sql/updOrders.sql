CREATE OR REPLACE FUNCTION updOrders() RETURNS TRIGGER AS $$
BEGIN
IF  (TG_OP = 'INSERT') THEN
    UPDATE orders 
	SET netamount = netamount + (new.price*new.quantity) , totalamount= totalamount + (products.price*new.quantity)
    from products
    where new.orderid=orders.orderid and new.prod_id=products.prod_id;

ELSIF (TG_OP = 'DELETE') THEN
    UPDATE orders 
	SET netamount = netamount - (old.price*old.quantity), totalamount= totalamount - (products.price*old.quantity)
    from products
    where old.orderid=orders.orderid and old.prod_id=products.prod_id;
ELSIF (TG_OP = 'UPDATE') THEN
    UPDATE orders 
	SET netamount = netamount - (old.price*old.quantity)+ (new.price*new.quantity),
	 totalamount= totalamount - (products.price*old.quantity) + (products.price*new.quantity)
    from products
    where old.orderid=orders.orderid and old.prod_id=products.prod_id;  
	
END IF;
	return null;
END;
$$ LANGUAGE plpgsql;


create trigger t_updOrders after update or insert or delete on orderdetail FOR EACH ROW EXECUTE procedure updOrders();






