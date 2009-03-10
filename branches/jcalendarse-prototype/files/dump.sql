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
DROP SEQUENCE public.users_userid_seq;
DROP SEQUENCE public.groups_groupid_seq;
DROP SEQUENCE public.grouproles_grouproleid_seq;
DROP SEQUENCE public.events_eventid_seq;
DROP FUNCTION public.insert_random_userdetails(integer, integer);
DROP TABLE public.venues;
DROP TABLE public.users;
DROP TABLE public.userdetails;
DROP TABLE public.permissions;
DROP TABLE public.member_of;
DROP TABLE public.groups;
DROP TABLE public.grouproles;
DROP TABLE public.events;
DROP TABLE public.courses;
DROP SEQUENCE public.courses_courseid_seq;
DROP TABLE public.colleges;
DROP SEQUENCE public.colleges_collegeid_seq;
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
    collegeid integer DEFAULT (-1) NOT NULL
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
-- Name: grouproles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grouproles (
    grouproleid integer NOT NULL,
    grouprolename character varying(20) NOT NULL
);


ALTER TABLE public.grouproles OWNER TO postgres;

--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groups (
    groupid integer NOT NULL,
    groupname character varying(20) NOT NULL
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: member_of; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE member_of (
    groupid integer NOT NULL,
    userid integer NOT NULL,
    grouproleid integer
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
-- Name: venues; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE venues (
    venueid integer NOT NULL,
    venue_name text NOT NULL
);


ALTER TABLE public.venues OWNER TO postgres;

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

SELECT pg_catalog.setval('events_eventid_seq', 41, true);


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

SELECT pg_catalog.setval('groups_groupid_seq', 2, true);


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

SELECT pg_catalog.setval('users_userid_seq', 27, true);


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

COPY colleges (collegeid, collegename) FROM stdin;
1	College of Engineering
2	College of Science
\.


--
-- Data for Name: courses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY courses (courseid, coursename, collegeid) FROM stdin;
1	BS Computer Science	1
2	MS Computer Science	1
3	BS Physics	2
\.


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY events (eventid, eventname, eventdetails, start_date, end_date, venueid) FROM stdin;
3	event2	\N	2009-02-06 11:29:11.845751	2009-02-06 11:29:11.845751	\N
8	event8	\N	2009-02-11 14:22:08.108659	2009-02-11 14:22:08.108659	\N
9	lkj		2009-02-15 01:05:00	2009-02-15 18:00:00	1
6	event4	This is a publicly viewable event	2009-02-08 16:15:00	2009-02-08 16:15:00	1
10	llj		2009-02-15 00:00:00	2009-02-16 17:05:00	1
21	an Admin event	students should not be able to see this XD	2009-03-03 00:00:00	2009-03-03 01:00:00	1
22	admin	test	2009-03-03 00:00:00	2009-03-03 01:00:00	1
23	ad		2009-03-03 00:00:00	2009-03-03 01:00:00	6
24	ad2		2009-03-03 00:00:00	2009-03-03 01:00:00	1
25	ad2		2009-03-03 00:00:00	2009-03-03 01:00:00	1
26	ad3		2009-03-03 00:00:00	2009-03-03 01:00:00	1
27	myevent	\n\n	2009-03-03 00:00:00	2009-03-03 00:10:00	1
28	admin and student event	:D	2009-03-05 00:00:00	2009-03-05 00:05:00	1
29	admin and student event	:D	2009-03-05 00:00:00	2009-03-05 00:05:00	1
30	totoong admin and student	:D	2009-03-05 00:00:00	2009-03-05 00:05:00	1
31	personal ni root		2009-03-05 00:00:00	2009-03-05 00:00:00	1
32	:D		2009-03-05 00:00:00	2009-03-05 00:05:00	1
33	:D		2009-03-05 00:00:00	2009-03-05 00:00:00	1
34	a	a	2009-03-06 00:00:00	2009-03-06 00:05:00	1
1	CS 165 MP2 due	OMG XIOU LI	2009-02-28 00:00:00	2009-03-30 12:00:00	1
35	XD	asdsad\nsdfas\n\n\nasdas	2009-03-09 00:00:00	2009-03-09 00:05:00	1
36	admin event ito	:D	2009-03-09 00:00:00	2009-03-09 00:05:00	1
37	XD		2009-03-09 00:00:00	2009-03-09 00:05:00	1
38	admin event ito		2009-03-09 00:00:00	2009-03-09 00:00:00	\N
39	a		2009-03-09 00:00:00	2009-03-09 00:05:00	\N
40	a		2009-03-09 00:00:00	2009-03-09 00:00:00	\N
41	a		2009-03-09 00:00:00	2009-03-09 00:05:00	\N
\.


--
-- Data for Name: grouproles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grouproles (grouproleid, grouprolename) FROM stdin;
1	read_events
2	edit_events
3	edit_members/events
\.


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY groups (groupid, groupname) FROM stdin;
1	admin
2	student
\.


--
-- Data for Name: member_of; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY member_of (groupid, userid, grouproleid) FROM stdin;
2	3	2
1	2	1
2	2	1
1	25	2
1	1	3
2	1	3
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY permissions (eventid, groupid, userid) FROM stdin;
1	1	\N
3	\N	2
6	\N	-1
9	\N	1
10	\N	1
21	\N	1
22	\N	\N
23	\N	1
24	\N	1
25	\N	1
26	1	\N
27	\N	3
28	\N	1
29	\N	1
30	\N	1
30	1	\N
30	2	\N
31	\N	1
32	\N	1
33	\N	1
33	1	\N
34	\N	1
35	\N	1
36	1	\N
37	\N	1
38	1	\N
39	\N	1
\.


--
-- Data for Name: userdetails; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY userdetails (userid, studentnumber, firstname, middlename, lastname, courseid, registered, rssfeed) FROM stdin;
-1	\N	\N	\N	\N	\N	t	62bdbefd1fecf993e951b419e82a6499
3	200701323	Juan Carlo	Uytiepo	Deoferio	1	t	933c7a1bce93a4ea47949df03f6b3b82
2	200701323	1	1	1	1	t	be13cbacdb98c076df1992f5a1081c0c
25	123456789	testadmin	test	test	1	t	5abbae29f29f97f8b815da1123f08ba3
1	200701323	a	b	c	1	t	0e8abb204f18f19c24d68e1e02c8c687
27	123456789	Juan Carlo	1	Deoferio	1	t	3c0eff39bee2c23493d1b1d7e8b8884c
26	200701323	q	q	q	1	t	b5232885b27b39fa1f1baa804a604866
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (userid, login, password) FROM stdin;
-1	public	\N
3	juancd	5f4dcc3b5aa765d61d8327deb882cf99
2	jc	5f4dcc3b5aa765d61d8327deb882cf99
25	mgsd	5f4dcc3b5aa765d61d8327deb882cf99
1	root	5f4dcc3b5aa765d61d8327deb882cf99
27	user2	5f4dcc3b5aa765d61d8327deb882cf99
26	user	5f4dcc3b5aa765d61d8327deb882cf99
\.


--
-- Data for Name: venues; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY venues (venueid, venue_name) FROM stdin;
1	Lecture Hall
2	Classroom 1
3	Classroom 2
4	Classroom 3
5	Classroom 4
6	Teaching Lab 1
7	Teaching Lab 2
8	Teaching Lab 3
\.


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

