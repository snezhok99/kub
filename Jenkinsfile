pipeline {
    agent {
        kubernetes {
            yamlFile 'builder.yaml'
        }
    }
    stages {
        stage('Build') {
            steps {
                echo 'Building the application...'
                // Add your build commands here
                sh 'docker-compose build'
            }
        }
        stage('Database Connection Test') {
            steps {
                echo 'Testing database connection...'
                // A shell command to check the database connection.
                // You would need to replace the placeholders with your actual DB credentials and host.
                // For a more robust test, you could run a simple query.
                sh 'mysql -h db2 -uroot -psecret -e "SELECT 1;"'
            }
        }
        stage('Frontend Test') {
            steps {
                echo 'Testing frontend...'
                // Use a tool like Cypress, Selenium, or a simple curl to check if the web server is running
                // You would need to have the web server deployed and accessible for this test.
                sh 'curl --fail http://127.0.0.1:8080'
            }
        }
        stage('Deploy to Kubernetes') {
            steps {
                echo 'Deploying application to Kubernetes...'
                // The provided document mentions this step. This will apply your Kubernetes manifests.
                withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
                    sh 'kubectl apply -f ./manifests -n crud'
                }
            }
        }
    }
}
