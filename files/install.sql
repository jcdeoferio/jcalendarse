--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

ALTER TABLE ONLY public.userdetails DROP CONSTRAINT userdetails_userid_fkey;
ALTER TABLE ONLY public.userdetails DROP CONSTRAINT userdetails_courseid_fkey;
ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_userid_fk;
ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_groupid_fk;
ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_eventid_fk;
ALTER TABLE ONLY public.member_of DROP CONSTRAINT member_of_userid_fk;
ALTER TABLE ONLY public.member_of DROP CONSTRAINT member_of_grouproleid_fk;
ALTER TABLE ONLY public.member_of DROP CONSTRAINT member_of_groupid_fk;
ALTER TABLE ONLY public.events DROP CONSTRAINT events_venueid_fk;
ALTER TABLE ONLY public.courses DROP CONSTRAINT courses_collegeid_fk;
ALTER TABLE ONLY public.venues DROP CONSTRAINT venues_pkey;
ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
ALTER TABLE ONLY public.userdetails DROP CONSTRAINT userdetails_userid_key;
ALTER TABLE ONLY public.userdetails DROP CONSTRAINT userdetails_rssfeed_key;
ALTER TABLE ONLY public.member_of DROP CONSTRAINT member_of_pk;
ALTER TABLE ONLY public.groups DROP CONSTRAINT groups_pkey;
ALTER TABLE ONLY public.grouproles DROP CONSTRAINT grouproles_pkey;
ALTER TABLE ONLY public.events DROP CONSTRAINT events_pkey;
ALTER TABLE ONLY public.courses DROP CONSTRAINT courses_pkey;
ALTER TABLE ONLY public.colleges DROP CONSTRAINT colleges_pkey;
ALTER TABLE public.venues ALTER COLUMN venueid DROP DEFAULT;
ALTER TABLE public.users ALTER COLUMN userid DROP DEFAULT;
ALTER TABLE public.groups ALTER COLUMN groupid DROP DEFAULT;
ALTER TABLE public.grouproles ALTER COLUMN grouproleid DROP DEFAULT;
ALTER TABLE public.events ALTER COLUMN eventid DROP DEFAULT;
DROP SEQUENCE public.venues_venueid_seq;
DROP TABLE public.venues;
DROP SEQUENCE public.users_userid_seq;
DROP TABLE public.users;
DROP TABLE public.userdetails;
DROP TABLE public.permissions;
DROP TABLE public.member_of;
DROP SEQUENCE public.groups_groupid_seq;
DROP TABLE public.groups;
DROP SEQUENCE public.grouproles_grouproleid_seq;
DROP TABLE public.grouproles;
DROP SEQUENCE public.events_eventid_seq;
DROP TABLE public.events;
DROP TABLE public.courses;
DROP SEQUENCE public.courses_courseid_seq;
DROP TABLE public.colleges;
DROP SEQUENCE public.colleges_collegeid_seq;
DROP FUNCTION public.insert_random_userdetails(integer, integer);
DROP PROCEDURAL LANGUAGE plpgsql;
DROP SCHEMA public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- Name: insert_random_userdetails(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION insert_random_userdetails(integer, integer) RETURNS integer
    AS $_$

DECLARE

	start_from ALIAS FOR $1;

	end_at ALIAS FOR $2;

BEGIN

	FOR userid IN start_from .. end_at LOOP

	    EXECUTE 'INSERT INTO userdetails (userid, studentnumber, firstname, middlename, lastname, courseid) VALUES ('||userid||', (random()*10000)::int, (random()*10000)::char(4), (random()*10000)::char(4), (random()*10000)::char(4), 1)';

	END LOOP;

	RETURN(0);

END;

$_$
    LANGUAGE plpgsql;


ALTER FUNCTION public.insert_random_userdetails(integer, integer) OWNER TO postgres;

--
-- Name: colleges_collegeid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE colleges_collegeid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.colleges_collegeid_seq OWNER TO postgres;

--
-- Name: colleges_collegeid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('colleges_collegeid_seq', 2, true);


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: colleges; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE colleges (
    collegeid integer DEFAULT nextval('colleges_collegeid_seq'::regclass) NOT NULL,
    collegename character varying NOT NULL
);


ALTER TABLE public.colleges OWNER TO postgres;

--
-- Name: courses_courseid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE courses_courseid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.courses_courseid_seq OWNER TO postgres;

--
-- Name: courses_courseid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('courses_courseid_seq', 3, true);


--
-- Name: courses; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE courses (
    courseid integer DEFAULT nextval('courses_courseid_seq'::regclass) NOT NULL,
    coursename character varying NOT NULL,
    collegeid integer DEFAULT 1
);


ALTER TABLE public.courses OWNER TO postgres;

--
-- Name: events; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE events (
    eventid integer NOT NULL,
    eventname text,
    eventdetails text,
    start_date timestamp without time zone NOT NULL,
    end_date timestamp without time zone NOT NULL,
    venueid integer
);


ALTER TABLE public.events OWNER TO postgres;

--
-- Name: events_eventid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE events_eventid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.events_eventid_seq OWNER TO postgres;

--
-- Name: events_eventid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE events_eventid_seq OWNED BY events.eventid;


--
-- Name: events_eventid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('events_eventid_seq', 1, true);


--
-- Name: grouproles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grouproles (
    grouproleid integer NOT NULL,
    grouprolename character varying(20) NOT NULL
);


ALTER TABLE public.grouproles OWNER TO postgres;

--
-- Name: grouproles_grouproleid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grouproles_grouproleid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.grouproles_grouproleid_seq OWNER TO postgres;

--
-- Name: grouproles_grouproleid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grouproles_grouproleid_seq OWNED BY grouproles.grouproleid;


--
-- Name: grouproles_grouproleid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grouproles_grouproleid_seq', 3, true);


--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groups (
    groupid integer NOT NULL,
    groupname character varying(20) NOT NULL
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: groups_groupid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE groups_groupid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.groups_groupid_seq OWNER TO postgres;

--
-- Name: groups_groupid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE groups_groupid_seq OWNED BY groups.groupid;


--
-- Name: groups_groupid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('groups_groupid_seq', 3, true);


--
-- Name: member_of; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE member_of (
    groupid integer NOT NULL,
    userid integer NOT NULL,
    grouproleid integer DEFAULT 3
);


ALTER TABLE public.member_of OWNER TO postgres;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE permissions (
    eventid integer NOT NULL,
    groupid integer,
    userid integer
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: userdetails; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE userdetails (
    userid integer NOT NULL,
    studentnumber integer,
    firstname character varying,
    middlename character varying,
    lastname character varying,
    courseid integer,
    year integer,
    registered boolean DEFAULT false NOT NULL,
    rssfeed character varying
);


ALTER TABLE public.userdetails OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    userid integer NOT NULL,
    login character varying(20) NOT NULL,
    password character varying(50)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_userid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_userid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.users_userid_seq OWNER TO postgres;

--
-- Name: users_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_userid_seq OWNED BY users.userid;


--
-- Name: users_userid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_userid_seq', 1, true);


--
-- Name: venues; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE venues (
    venueid integer NOT NULL,
    venue_name text NOT NULL
);


ALTER TABLE public.venues OWNER TO postgres;

--
-- Name: venues_venueid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE venues_venueid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.venues_venueid_seq OWNER TO postgres;

--
-- Name: venues_venueid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE venues_venueid_seq OWNED BY venues.venueid;


--
-- Name: venues_venueid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('venues_venueid_seq', 8, true);


--
-- Name: eventid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE events ALTER COLUMN eventid SET DEFAULT nextval('events_eventid_seq'::regclass);


--
-- Name: grouproleid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE grouproles ALTER COLUMN grouproleid SET DEFAULT nextval('grouproles_grouproleid_seq'::regclass);


--
-- Name: groupid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE groups ALTER COLUMN groupid SET DEFAULT nextval('groups_groupid_seq'::regclass);


--
-- Name: userid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE users ALTER COLUMN userid SET DEFAULT nextval('users_userid_seq'::regclass);


--
-- Name: venueid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE venues ALTER COLUMN venueid SET DEFAULT nextval('venues_venueid_seq'::regclass);


--
-- Data for Name: colleges; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO colleges VALUES (1, 'College of Engineering');
INSERT INTO colleges VALUES (2, 'College of Science');


--
-- Data for Name: courses; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO courses VALUES (1, 'BS Computer Science', 1);
INSERT INTO courses VALUES (2, 'MS Computer Science', 1);
INSERT INTO courses VALUES (3, 'BS Physics', 2);


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO events VALUES (1, 'Hello World!', 'Welcome to jCalendar!', '2009-03-06 00:00:00', '2009-03-06 12:00:00', 1);


--
-- Data for Name: grouproles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO grouproles VALUES (1, 'Group Admin');
INSERT INTO grouproles VALUES (2, 'Group Moderator');
INSERT INTO grouproles VALUES (3, 'Group Member');


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO groups VALUES (1, 'admin');
INSERT INTO groups VALUES (2, 'student');
INSERT INTO groups VALUES (-1, 'public');
INSERT INTO groups VALUES (3, 'faculty');


--
-- Data for Name: member_of; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO member_of VALUES (1, 1, 1);
INSERT INTO member_of VALUES (2, 1, 1);
INSERT INTO member_of VALUES (3, 1, 1);
INSERT INTO member_of VALUES (-1, 1, 1);


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO permissions VALUES (1, -1, NULL);


--
-- Data for Name: userdetails; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO userdetails VALUES (1, NULL, NULL, NULL, NULL, 1, NULL, true, '6e95a5fe6689a27cac481d13ac88ddc6 ');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO users VALUES (1, 'root', '5f4dcc3b5aa765d61d8327deb882cf99');


--
-- Data for Name: venues; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO venues VALUES (1, 'Lecture Hall');
INSERT INTO venues VALUES (2, 'Classroom 1');
INSERT INTO venues VALUES (3, 'Classroom 2');
INSERT INTO venues VALUES (4, 'Classroom 3');
INSERT INTO venues VALUES (5, 'Classroom 4');
INSERT INTO venues VALUES (6, 'Teaching Lab 1');
INSERT INTO venues VALUES (7, 'Teaching Lab 2');
INSERT INTO venues VALUES (8, 'Teaching Lab 3');


--
-- Name: colleges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY colleges
    ADD CONSTRAINT colleges_pkey PRIMARY KEY (collegeid);


--
-- Name: courses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (courseid);


--
-- Name: events_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY events
    ADD CONSTRAINT events_pkey PRIMARY KEY (eventid);


--
-- Name: grouproles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grouproles
    ADD CONSTRAINT grouproles_pkey PRIMARY KEY (grouproleid);


--
-- Name: groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (groupid);


--
-- Name: member_of_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY member_of
    ADD CONSTRAINT member_of_pk PRIMARY KEY (groupid, userid);


--
-- Name: userdetails_rssfeed_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY userdetails
    ADD CONSTRAINT userdetails_rssfeed_key UNIQUE (rssfeed);


--
-- Name: userdetails_userid_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY userdetails
    ADD CONSTRAINT userdetails_userid_key UNIQUE (userid);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (userid);


--
-- Name: venues_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY venues
    ADD CONSTRAINT venues_pkey PRIMARY KEY (venueid);


--
-- Name: courses_collegeid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY courses
    ADD CONSTRAINT courses_collegeid_fk FOREIGN KEY (collegeid) REFERENCES colleges(collegeid);


--
-- Name: events_venueid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY events
    ADD CONSTRAINT events_venueid_fk FOREIGN KEY (venueid) REFERENCES venues(venueid);


--
-- Name: member_of_groupid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY member_of
    ADD CONSTRAINT member_of_groupid_fk FOREIGN KEY (groupid) REFERENCES groups(groupid);


--
-- Name: member_of_grouproleid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY member_of
    ADD CONSTRAINT member_of_grouproleid_fk FOREIGN KEY (grouproleid) REFERENCES grouproles(grouproleid);


--
-- Name: member_of_userid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY member_of
    ADD CONSTRAINT member_of_userid_fk FOREIGN KEY (userid) REFERENCES users(userid);


--
-- Name: permissions_eventid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permissions_eventid_fk FOREIGN KEY (eventid) REFERENCES events(eventid);


--
-- Name: permissions_groupid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permissions_groupid_fk FOREIGN KEY (groupid) REFERENCES groups(groupid);


--
-- Name: permissions_userid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permissions_userid_fk FOREIGN KEY (userid) REFERENCES users(userid);


--
-- Name: userdetails_courseid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY userdetails
    ADD CONSTRAINT userdetails_courseid_fkey FOREIGN KEY (courseid) REFERENCES courses(courseid);


--
-- Name: userdetails_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY userdetails
    ADD CONSTRAINT userdetails_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

