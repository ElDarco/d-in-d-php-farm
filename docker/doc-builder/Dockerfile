FROM python:3
RUN pip install sphinx myst-parser sphinx-intl
RUN cd docs/

RUN make -e SPHINXOPTS="-D language='en'" html
RUN mv _build/html _build/en

RUN make -e SPHINXOPTS="-D language=ru'" html
RUN mv _build/html _build/ru