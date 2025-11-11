provider "aws" {
  region = "ap-south-1"
}

resource "aws_security_group" "web_sg" {
  name        = "allow_http_ssh"
  description = "Allow SSH and HTTP access"

  ingress {
    description = "Allow SSH"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    description = "Allow HTTP"
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "allow_http_ssh"
  }
}

resource "aws_instance" "web" {
  ami           = "ami-0e306788ff2473ccb"  # Amazon Linux 2 AMI (Mumbai)
  instance_type = "t3.micro"
  key_name      = "agri-key"

  security_groups = [aws_security_group.web_sg.name]

  user_data = <<-EOF
              #!/bin/bash
              yum update -y
              yum install -y httpd php php-mysqli mariadb105
              systemctl start httpd
              systemctl enable httpd
              echo "<h1>Agri Portal Deployed Successfully</h1>" > /var/www/html/index.php
              EOF

  tags = {
    Name = "Agri-Portal-Server"
  }
}

# ✅ Output the instance public IP so we can use it for Ansible
output "public_ip" {
  description = "Public IP of the EC2 instance"
  value       = aws_instance.web.public_ip
}
