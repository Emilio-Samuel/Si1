
create or replace function getTopVentas(integer default date_part('year', current_date)::integer - 3)
returns table(pelicula character varying(255), agno integer, ventas bigint) as $$
declare
	selected_year alias for $1;
    --each_year integer;
begin
	return query
	select distinct on (q.year_sold) q.movietitle, q.year_sold, count(*)
    from (select movietitle, date_part('year', orderdate)::integer as year_sold
          from ((orders inner join orderdetail using(orderid))
                inner join products using (prod_id))
          		inner join imdb_movies using(movieid)) as q
          where year_sold >= selected_year
          group by movietitle, year_sold
          order by year_sold asc, count desc;

	/*
	for each_year in selected_year..(date_part('year', current_date)::integer) loop
    	select imdb_movies.year, imdb_movies.movietitle, sold
        into top_ventas_agno
        from (select movieid, sold, dense_rank() over (order by sold desc) as rnk
            from (select movieid, count(*) as sold
                  from orderdetail inner join products using(prod_id)
                  where orderid in
                      (select orderid
                       from orders
                       where date_part('year', orderdate)::integer = each_year)
                       group by movieid) as top) as top
             inner join imdb_movies using(movieid)
        where top.movieid = imdb_movies.movieid and 
        	  rnk = 1;
    end loop;
  
    return top_ventas_agno;
    */
end;
$$ language plpgsql;

select * from getTopVentas();