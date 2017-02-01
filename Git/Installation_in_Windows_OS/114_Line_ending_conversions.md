###### Configuring the line ending conversions

**How should Git treat line endings in text files?**

- [ ] Checkout Windows-style, commit Unix-style line endings

    Git will convert LF to CRLF when checking out text files. When committing text files,
    CRLF will be converted to LF. For cross-platform projects, this is the recommended setting
    on Windows ("core.autocrlf" is set to "true")

- [ ] Checkout as-is, commit Unix-style line endings

    Git will not perform any conversion when checking out text files. When committing text files,
    CRLF will be converted to LF. For cross-platform projects, this is recommended setting on Unix
    ("core.autocrlf" is set to "input")

- [ ] Checkout as-is, commit as-is

    Git will not perform any conversions when checking out or committing text files. Choosing this
    option is not recommended for cross-platform projects ("core.autocrlf" is set to "false")