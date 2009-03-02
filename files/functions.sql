CREATE OR REPLACE FUNCTION insert_random_userdetails(int, int) RETURNS int AS $$
DECLARE
	start_from ALIAS FOR $1;
	end_at ALIAS FOR $2;
BEGIN
	FOR userid IN start_from .. end_at LOOP
	    EXECUTE 'INSERT INTO userdetails (userid, studentnumber, firstname, middlename, lastname, courseid) VALUES ('||userid||', (random()*10000)::int, (random()*10000)::char(4), (random()*10000)::char(4), (random()*10000)::char(4), 1)';
	END LOOP;

	RETURN(0);
END;
$$ LANGUAGE plpgsql;