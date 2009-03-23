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

SELECT pg_catalog.setval('events_eventid_seq', 20, true);


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

SELECT pg_catalog.setval('groups_groupid_seq', 2, true);


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

SELECT pg_catalog.setval('users_userid_seq', 71, true);


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
5	event3	\N	2009-02-08 00:00:00	2009-02-08 12:00:00	\N
9	lkj		2009-02-15 01:05:00	2009-02-15 18:00:00	1
7	event7	Details of the event are as follows.\r\n\r\nThis description intentionally left blank	2009-02-15 12:00:00	2009-02-15 11:55:00	4
10	llj		2009-02-15 00:00:00	2009-02-03 17:05:00	1
11	1	test	2009-02-26 00:00:00	2009-02-26 17:05:00	1
1	CS 165 MP2 due	OMG XIOU LI	2009-01-30 00:00:00	2009-01-30 12:00:00	1
13	val's day		2009-03-04 00:00:00	2009-03-04 00:05:00	\N
14	foo	redfdsq	2009-03-04 00:00:00	2009-03-04 00:05:00	1
12	val's day	this is 6 days before valentine's day	2009-02-08 00:00:00	2009-02-08 23:55:00	\N
2	event1	Ooooo event 1	2009-02-06 10:10:00	2009-03-09 10:10:00	4
20	Event name		2009-03-15 00:00:00	2009-03-15 00:00:00	\N
6	event4	This is a publicly viewable event	2009-02-08 16:15:00	2009-02-10 00:00:00	1
\.


--
-- Data for Name: grouproles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grouproles (grouproleid, grouprolename) FROM stdin;
1	Group Admin
2	Group Moderator
3	Group Member
\.


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY groups (groupid, groupname) FROM stdin;
1	admin
2	student
-1	public
\.


--
-- Data for Name: member_of; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY member_of (groupid, userid, grouproleid) FROM stdin;
1	1	1
2	2	3
1	3	2
2	3	2
-1	1	1
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
7	\N	1
9	\N	1
10	\N	1
11	\N	1
12	\N	1
13	\N	1
14	\N	1
20	\N	1
6	-1	\N
7	-1	\N
\.


--
-- Data for Name: userdetails; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY userdetails (userid, studentnumber, firstname, middlename, lastname, courseid, year, registered, rssfeed) FROM stdin;
-1	\N	\N	\N	\N	\N	\N	f	62bdbefd1fecf993e951b419e82a6499
2	\N	\N	\N	\N	\N	\N	f	be13cbacdb98c076df1992f5a1081c0c
1	\N	\N	\N	\N	\N	\N	t	0e8abb204f18f19c24d68e1e02c8c687
49	6570	522.	7572	9558	1	\N	f	\N
3	200701323	Juan Carlo	Uytiepo	Deoferio	1	2	f	933c7a1bce93a4ea47949df03f6b3b82
13	858	1272	4281	7583	1	\N	f	\N
14	3223	7268	4273	9088	1	\N	f	\N
15	3986	3652	6227	532.	1	\N	f	\N
16	1787	5726	9715	7059	1	\N	f	\N
17	4230	1212	745.	5710	1	\N	f	\N
18	5442	2591	3570	5872	1	\N	f	\N
19	8319	9428	5375	8673	1	\N	f	\N
20	3141	8048	8646	3998	1	\N	f	\N
21	9321	2927	1581	2544	1	\N	f	\N
22	197	5855	1632	4183	1	\N	f	\N
23	9509	7859	4715	1296	1	\N	f	\N
24	3586	4430	8355	7816	1	\N	f	\N
25	5643	9101	3527	1085	1	\N	f	\N
26	1693	7097	6957	11.3	1	\N	f	\N
27	6526	2332	8684	9666	1	\N	f	\N
28	381	7331	3665	9701	1	\N	f	\N
29	259	5247	2245	455.	1	\N	f	\N
30	1103	3878	4639	612.	1	\N	f	\N
31	1738	9354	1908	5324	1	\N	f	\N
32	3785	263.	3141	9427	1	\N	f	\N
33	9365	6668	512.	1057	1	\N	f	\N
34	3766	7469	1069	292.	1	\N	f	\N
35	9803	9753	9958	183.	1	\N	f	\N
36	7085	3624	9885	7344	1	\N	f	\N
37	8872	2131	7800	9975	1	\N	f	\N
38	6010	2439	587.	7748	1	\N	f	\N
39	1793	2495	3073	5578	1	\N	f	\N
40	2760	6214	5005	2124	1	\N	f	\N
41	2884	5518	3182	6650	1	\N	f	\N
42	2988	4251	6942	2791	1	\N	f	\N
43	4005	6901	2975	1090	1	\N	f	\N
44	526	2860	8434	9397	1	\N	f	\N
45	4992	6234	9373	1002	1	\N	f	\N
46	8673	9960	8750	466.	1	\N	f	\N
47	2456	1823	6045	5215	1	\N	f	\N
48	8038	1051	7340	922.	1	\N	f	\N
50	4774	4514	2349	8779	1	\N	f	\N
51	1416	5324	9869	1942	1	\N	f	\N
52	8185	8303	1339	3177	1	\N	f	\N
53	4538	713.	4179	3211	1	\N	f	\N
54	674	2929	3678	3130	1	\N	f	\N
55	4753	9723	8345	2791	1	\N	f	\N
56	775	5686	3713	7344	1	\N	f	\N
57	6209	1285	6902	983.	1	\N	f	\N
58	5801	9251	9762	7217	1	\N	f	\N
59	4576	9632	9159	2761	1	\N	f	\N
60	7936	499.	5938	2473	1	\N	f	\N
61	1212	117.	5684	1886	1	\N	f	\N
62	3047	9363	5016	7800	1	\N	f	\N
63	9087	3362	591.	9861	1	\N	f	\N
64	9048	4305	7205	5257	1	\N	f	\N
65	5591	4108	6240	1391	1	\N	f	\N
66	3360	6003	8609	7936	1	\N	f	\N
67	5636	7768	698.	3571	1	\N	f	\N
68	8267	6636	6045	9479	1	\N	f	\N
69	6755	1730	1365	9802	1	\N	f	\N
70	1093	6382	7602	180.	1	\N	f	\N
71	9744	8194	41.4	8792	1	\N	f	\N
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (userid, login, password) FROM stdin;
1	root	5f4dcc3b5aa765d61d8327deb882cf99
2	jc	5f4dcc3b5aa765d61d8327deb882cf99
-1	public	\N
13	9116	7563
14	6523	4702
15	805.	3663
16	276.	8559
17	2852	2516
18	2183	9938
19	4903	9736
20	2261	3286
21	7963	5976
22	3436	2225
23	6584	548.
24	6835	4962
25	2528	308.
26	9009	4376
27	238.	4352
28	6154	9355
29	1915	2678
30	4057	2721
31	6342	4334
32	1281	9195
33	6850	3464
34	9134	1753
35	3201	1396
36	5040	1164
37	7372	8477
38	3390	3957
39	9025	226.
40	8919	1554
41	535.	7929
42	5931	773.
43	2281	2086
44	129.	4197
45	4764	4186
46	6918	1107
47	8521	8200
48	302.	5371
49	1664	9436
50	7125	4866
51	832.	2165
52	6031	8205
53	642.	9421
54	2163	9668
55	9648	1082
56	1222	183.
57	9012	7153
58	956.	1293
59	9239	1086
60	5490	4004
61	5272	2409
62	5111	3794
63	609.	5414
64	9165	2274
65	4851	6290
66	7140	5684
67	8456	3171
68	3889	9098
69	2593	6052
70	8766	2241
71	7135	9989
3	juancd	5f4dcc3b5aa765d61d8327deb882cf99
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

