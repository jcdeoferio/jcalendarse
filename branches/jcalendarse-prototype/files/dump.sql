--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

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
-- Name: course_member_of; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE course_member_of (
    collegeid integer,
    courseid integer
);


ALTER TABLE public.course_member_of OWNER TO postgres;

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
    coursename character varying NOT NULL
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
    studentnumber integer NOT NULL,
    firstname character varying NOT NULL,
    middlename character varying,
    lastname character varying NOT NULL,
    courseid integer NOT NULL,
    year integer NOT NULL,
    registered boolean DEFAULT false NOT NULL
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

SELECT pg_catalog.setval('events_eventid_seq', 11, true);


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

SELECT pg_catalog.setval('grouproles_grouproleid_seq', 2, true);


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

SELECT pg_catalog.setval('users_userid_seq', 4, true);


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
-- Data for Name: course_member_of; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY course_member_of (collegeid, courseid) FROM stdin;
1	1
1	2
2	3
\.


--
-- Data for Name: courses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY courses (courseid, coursename) FROM stdin;
1	BS Computer Science
2	MS Computer Science
3	BS Physics
\.


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY events (eventid, eventname, eventdetails, start_date, end_date, venueid) FROM stdin;
3	event2	\N	2009-02-06 11:29:11.845751	2009-02-06 11:29:11.845751	\N
5	event3	\N	2009-02-08 00:00:00	2009-02-08 12:00:00	\N
8	event8	\N	2009-02-11 14:22:08.108659	2009-02-11 14:22:08.108659	\N
9	lkj		2009-02-15 01:05:00	2009-02-15 18:00:00	1
2	event1	Ooooo event 1	2009-02-15 10:10:00	2009-12-15 10:10:00	4
7	event7	Details of the event are as follows.\n\nThis description intentionally left blank	2009-02-15 12:00:00	2009-02-15 11:55:00	4
10	llj		2009-02-15 00:00:00	2009-02-03 17:05:00	1
6	event4	This is a publicly viewable event	2009-02-08 16:15:00	2009-02-08 16:15:00	1
11	1	test	2009-02-26 00:00:00	2009-02-26 17:05:00	1
1	CS 165 MP2 due	OMG XIOU LI	2009-01-30 00:00:00	2009-01-30 12:00:00	1
\.


--
-- Data for Name: grouproles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grouproles (grouproleid, grouprolename) FROM stdin;
1	Group Admin
2	Group Moderator
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
1	1	\N
2	2	\N
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY permissions (eventid, groupid, userid) FROM stdin;
1	1	\N
2	1	\N
2	2	\N
3	\N	2
5	\N	1
6	\N	-1
7	\N	1
7	\N	-1
9	\N	1
10	\N	1
11	\N	1
\.


--
-- Data for Name: userdetails; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY userdetails (userid, studentnumber, firstname, middlename, lastname, courseid, year, registered) FROM stdin;
4	200701323	Juan Carlo	Uytiepo	Deoferio	1	2	f
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (userid, login, password) FROM stdin;
1	root	5f4dcc3b5aa765d61d8327deb882cf99
2	jc	5f4dcc3b5aa765d61d8327deb882cf99
-1	public	\N
4	juancd	5f4dcc3b5aa765d61d8327deb882cf99
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
-- Name: userdetails_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY userdetails
    ADD CONSTRAINT userdetails_pkey PRIMARY KEY (studentnumber);


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
-- Name: course_member_of_collegeid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY course_member_of
    ADD CONSTRAINT course_member_of_collegeid_fkey FOREIGN KEY (collegeid) REFERENCES colleges(collegeid);


--
-- Name: course_member_of_courseid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY course_member_of
    ADD CONSTRAINT course_member_of_courseid_fkey FOREIGN KEY (courseid) REFERENCES courses(courseid);


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

