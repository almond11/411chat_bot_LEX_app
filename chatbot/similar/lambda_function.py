from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):
    results = []
    recipe = event['currentIntent']['slots']['recipe']
        
    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()    
       
    similarity_query='MATCH (r1:Recipes{recipeName:"'+recipe+'"})'
    e=""" -[:IS_MADE_OF]->(ingred1) WITH r1, collect(id(ingred1)) AS r1Ingred
        MATCH (r2:Recipes)-[:IS_MADE_OF]->(ingred2) WHERE r1<>r2
        WITH r1,r1Ingred,r2,collect(id(ingred2)) as r2Ingred
        RETURN r2.recipeName as sim, gds.alpha.similarity.jaccard(r1Ingred, r2Ingred) AS similarity
        ORDER BY similarity DESC
        LIMIT 6
    """
    similarity_query+=e
    result=session.run(similarity_query,{}) 
    print(similarity_query)
    ans=""
    results=[]
    session.close()
    for record in result:
        item = {'ingredients':record['sim']}
        print(record)
        print(record['sim'])
        ans+=str(record['sim'])+" --- "
        results.append(item)
    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "The similar recipes of "+ recipe + " is   " + ans +" Would you like to try one?" }   }    }    
    return response