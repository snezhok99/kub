pipeline {

  agent {
    kubernetes {
      yamlFile 'builder.yaml'
    }
  }

  stages {

    stage('Checkout Code') {
      steps {
        checkout scm
      }
    }

    stage('Test Database') {
      steps {
        container('kubectl') {
          sh '''
            echo "Проверяем доступ к базе данных..."
            nc -zv 10.40.0.2 3306  exit 1
          '''
        }
      }
    }

    stage('Test Frontend') {
      steps {
        container('kubectl') {
          sh '''
            echo "Проверяем доступ к фронтенду..."
            curl -sSf http://192.168.0.100:80  exit 1
            echo "Фронт доступен ✅"
          '''
        }
      }
    }

    stage('Deploy App to Kubernetes') {
      steps {
        container('kubectl') {
          withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
            sh 'kubectl create ns crud || true'
            sh 'kubectl apply -f ./manifests -n crud'
          }
        }
      }
    }

  }
}
