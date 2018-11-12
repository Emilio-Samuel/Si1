select customerid
from customers
except 
    select customerid
    from orders
    where status = 'Paid';