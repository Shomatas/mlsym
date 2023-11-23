CREATE TABLE public.adresses
(
    id uuid NOT NULL,
    country text NOT NULL,
    city text NOT NULL,
    street text NOT NULL,
    house_number text NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.adresses
    OWNER to postgres;