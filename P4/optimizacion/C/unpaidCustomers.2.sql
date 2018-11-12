select customerid
from (select customerid
      from customers
      union all
      select customerid
      from orders
      where status='Paid'
      ) as A
group by customerid
having count(*) = 1;