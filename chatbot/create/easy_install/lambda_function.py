from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):
    results = []
    recipe = event['currentIntent']['slots']['recipe']
    i=[""] * 6
    
    i[0] = event['currentIntent']['slots']['ione'].strip()
    i[1] = event['currentIntent']['slots']['itwo'].strip()
    i[2] = event['currentIntent']['slots']['iFour'].strip()
    i[3] = event['currentIntent']['slots']['iFive'].strip()
   
    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()
 
    #create recipe node
    cypher_query5 ='CREATE (m:Recipes{recipeName:"'+recipe+'"}) return m'
    session.run(cypher_query5,{})

    #loop and create recipe relationship with all the ingredients
    for j in range(4):
        if len(i[j])>0:
        
            cypher_query6 ='MATCH (m:Recipes{recipeName:"'+recipe+'"}) MATCH(i:Ingredients{ingredientName:"'+i[j]+'"}) CREATE (m)-[:IS_MADE_OF]->(i)'
            print(cypher_query6)

            session.run(cypher_query6,{})
    session.close()
    print(cypher_query5)

    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "The new recipe "+recipe +" has been inserted in DB!" }   }    }    
    return response