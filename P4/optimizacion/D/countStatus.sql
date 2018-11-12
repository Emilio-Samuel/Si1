explain select count(*)
from orders
where status is null;

explain select count(*)
from orders
where status = 'Shipped';

-- creacion del indice
drop index if exists orders_status; 
create index orders_status on orders(status);

explain select count(*)
from orders
where status is null;

explain select count(*)
from orders
where status = 'Shipped';

--analyze de la tabla
analyze orders;

explain
select count(*)
from orders
where status is null;

explain
select count(*)
from orders
where status = 'Shipped';

-- despues
explain
select count(*)
from orders
where status = 'Paid';

explain
select count(*)
from orders
where status = 'Processed';