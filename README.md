# MailSpoof
MailSpoof is a simple program that scans SPF and DMARC records for issues that could allow email spoofing.

## Getting Started

Follow these steps to use the MailSpoof tool using Docker:

### Prerequisites

- Docker installed on your system

### Usage

1. Clone this repository:


```
git clone https://github.com/yourusername/YourRepositoryName.git
cd YourRepositoryName
```

2. Build the Docker image:

```
docker build -t mailspoof .
```

3. Run the Docker container and specify the target URL (replace `<url>` with the actual URL):

```
docker run --rm mailspoof <url> [--output=json]
```

Replace `<url>` with the target URL you want to check. You can also include the `--output=json` flag if you want JSON output.

4. Access the output:

To access the output, copy the `output.txt` file from the container to your host system:

```
docker cp <container_id>:/app/output.txt ./output.txt
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.