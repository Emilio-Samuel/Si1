
create or replace function getTopMonths(integer, integer)
returns table(year integer, month integer) as $$

    select gain.year, gain.month from
    (select
        date_part('year', orderdate)::integer as year,
        date_part('month', orderdate)::integer as month,
        sum(totalamount) as income
    from orders
    group by year, month) as gain
    inner join (select
        date_part('year', orderdate)::integer as year,
        date_part('month', orderdate)::integer as month,
        count(prod_id) as products
    from orders inner join orderdetail using(orderid)
    group by year, month) as total_sold
    using(year, month)
    where income > $1 or products > $2

$$ language sql;

--select * from getTopMonths(310000, 17000);