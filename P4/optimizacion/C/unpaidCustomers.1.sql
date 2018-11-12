select customerid
from customers
where customerid not in
    (select customerid
     from otders
     where status = 'Paid');