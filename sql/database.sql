--
-- PostgreSQL database dump
--

-- Dumped from database version 16.6 (Ubuntu 16.6-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.6 (Ubuntu 16.6-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: triggerdate(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.triggerdate() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
	if (select (old.date_start, old.date_end) overlaps (new.date_start, new.date_end)) then
		return old;
	end if;
	return new;
end; $$;


ALTER FUNCTION public.triggerdate() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: disponibilities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.disponibilities (
    uid character varying(32) NOT NULL,
    uid_user character varying(32) NOT NULL,
    date_start date DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_end date DEFAULT CURRENT_TIMESTAMP NOT NULL,
    type integer DEFAULT 1 NOT NULL,
    reason integer DEFAULT 1 NOT NULL,
    state integer NOT NULL
);


ALTER TABLE public.disponibilities OWNER TO postgres;

--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groups (
    uid character varying(32) NOT NULL
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservations (
    uid_teacher character varying(32) NOT NULL,
    uid_student character varying(32) NOT NULL,
    uid_disponibilities character varying(32) NOT NULL
);


ALTER TABLE public.reservations OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id integer NOT NULL
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: tutoring; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tutoring (
    uid_student character varying(32) NOT NULL,
    uid_teacher character varying(32) NOT NULL
);


ALTER TABLE public.tutoring OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    uid character varying(32) NOT NULL,
    email character varying(255) NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users_groups (
    uid_user character varying(32) NOT NULL,
    uid_group character varying(32) NOT NULL
);


ALTER TABLE public.users_groups OWNER TO postgres;

--
-- Name: users_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users_roles (
    uid_user character varying(32) NOT NULL,
    id_role integer NOT NULL
);


ALTER TABLE public.users_roles OWNER TO postgres;

--
-- Data for Name: disponibilities; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tutoring; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES ('a', 'a');


--
-- Data for Name: users_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: users_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: disponibilities disponibilities_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disponibilities
    ADD CONSTRAINT disponibilities_pk PRIMARY KEY (uid);


--
-- Name: groups groups_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pk PRIMARY KEY (uid);


--
-- Name: reservations reservations_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pk PRIMARY KEY (uid_teacher, uid_student, uid_disponibilities);


--
-- Name: roles roles_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pk PRIMARY KEY (id);


--
-- Name: tutoring tutoring_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tutoring
    ADD CONSTRAINT tutoring_pk PRIMARY KEY (uid_student, uid_teacher);


--
-- Name: users_groups users_groups_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_groups
    ADD CONSTRAINT users_groups_pk PRIMARY KEY (uid_user, uid_group);


--
-- Name: users users_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk PRIMARY KEY (uid);


--
-- Name: users_roles users_roles_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_roles
    ADD CONSTRAINT users_roles_pk PRIMARY KEY (uid_user, id_role);


--
-- Name: users users_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_unique UNIQUE (email);


--
-- Name: disponibilities trigger1; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger1 BEFORE INSERT ON public.disponibilities FOR EACH ROW EXECUTE FUNCTION public.triggerdate();


--
-- Name: disponibilities disponibilities_users_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disponibilities
    ADD CONSTRAINT disponibilities_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);


--
-- Name: reservations reservations_disponibilities_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_disponibilities_fk FOREIGN KEY (uid_disponibilities) REFERENCES public.disponibilities(uid);


--
-- Name: reservations reservations_users_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_users_fk FOREIGN KEY (uid_teacher) REFERENCES public.users(uid);


--
-- Name: reservations reservations_users_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_users_fk_1 FOREIGN KEY (uid_student) REFERENCES public.users(uid);


--
-- Name: tutoring tutoring_users_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tutoring
    ADD CONSTRAINT tutoring_users_fk FOREIGN KEY (uid_student) REFERENCES public.users(uid);


--
-- Name: tutoring tutoring_users_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tutoring
    ADD CONSTRAINT tutoring_users_fk_1 FOREIGN KEY (uid_teacher) REFERENCES public.users(uid);


--
-- Name: users_groups users_groups_groups_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_groups
    ADD CONSTRAINT users_groups_groups_fk FOREIGN KEY (uid_group) REFERENCES public.groups(uid);


--
-- Name: users_groups users_groups_users_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_groups
    ADD CONSTRAINT users_groups_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);


--
-- Name: users_roles users_roles_roles_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_roles
    ADD CONSTRAINT users_roles_roles_fk FOREIGN KEY (id_role) REFERENCES public.roles(id);


--
-- Name: users_roles users_roles_users_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_roles
    ADD CONSTRAINT users_roles_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);


--
-- PostgreSQL database dump complete
--
